<?php

namespace App\Models;

use App\Core\Model;

use App\Models\Outcome;

use App\DTO\EventDTO;

class Event extends Model
{
    public function __construct()
    {
        parent::__construct('events');
    }

    public function getEventsWithRates()
    {
        $Outcome = new Outcome();
        $outcomeNames = $Outcome->getNames();

        $columns = [];
        foreach ($outcomeNames as $key => $value) {
            //$columns[] = "MAX(CASE WHEN o.name = '{$value['name']}' THEN CONCAT(o.id, '_', ot.label) ELSE NULL END) AS outcome{$value['name']}";
            $columns[] = "CONCAT(ROUND(0.2 * POWER(5, GREATEST(1.01, LEAST(2, 2 - (SUM(CASE WHEN b.outcome = '{$value['name']}' THEN b.amount * c.rate ELSE 0 END) / total_sum.totalAmount)))), 2), '//{$value['label']}') AS 'outcome{$value['name']}'";
        }
        $columnsSql = implode(", ", $columns);

        $this->DB()->query("
            WITH total_sum AS (
                SELECT 
                    e.id AS eventId, 
                    CASE WHEN SUM(b.amount * c.rate) IS NULL THEN 1 ELSE SUM(b.amount * c.rate) END AS totalAmount 
                FROM 
                    events e 
                LEFT JOIN 
                    bets b ON b.eventId = e.id AND b.status = 'Pending'
                LEFT JOIN 
                    currencies c ON c.code = b.currency 
                GROUP BY 
                    e.id
            )

            SELECT 
                e.id,
                t1.name AS teamOneName,
                t2.name AS teamTwoName,
                {$columnsSql}
            FROM 
                events e
            LEFT JOIN
                bets b ON b.eventId = e.id
            LEFT JOIN 
                currencies c ON c.code = b.currency
            LEFT JOIN
                teams t1 ON t1.id = e.teamOne
            LEFT JOIN
                teams t2 ON t2.id = e.teamTwo
            LEFT JOIN 
                total_sum ON b.eventId = total_sum.eventId
            GROUP BY 
                total_sum.eventId;
        ");
        //return $this->DB()->fetchAll();
        return EventDTO::createArray($this->DB()->fetchAll());
    }

    public function getOneEventWithRates(int $id)
    {
        $Outcome = new Outcome();
        $outcomeNames = $Outcome->getNames();

        $columns = [];
        foreach ($outcomeNames as $key => $value) {
            //$columns[] = "MAX(CASE WHEN o.name = '{$value['name']}' THEN CONCAT(o.id, '_', ot.label) ELSE NULL END) AS outcome{$value['name']}";
            $columns[] = "CONCAT(ROUND(0.2 * POWER(5, GREATEST(1.01, LEAST(2, 2 - (SUM(CASE WHEN b.outcome = '{$value['name']}' THEN b.amount * c.rate ELSE 0 END) / total_sum.totalAmount)))), 2), '//{$value['label']}') AS 'outcome{$value['name']}'";
        }
        $columnsSql = implode(", ", $columns);

        $this->DB()->query("
            WITH total_sum AS (
                SELECT 
                    e.id AS eventId, 
                    CASE WHEN SUM(b.amount * c.rate) IS NULL THEN 1 ELSE SUM(b.amount * c.rate) END AS totalAmount 
                FROM 
                    events e 
                LEFT JOIN 
                    bets b ON b.eventId = e.id AND b.status = 'Pending'
                LEFT JOIN 
                    currencies c ON c.code = b.currency 
                GROUP BY 
                    e.id
            )

            SELECT 
                e.id,
                t1.name AS teamOneName,
                t2.name AS teamTwoName,
                {$columnsSql}
            FROM 
                events e
            LEFT JOIN
                bets b ON b.eventId = e.id
            LEFT JOIN 
                currencies c ON c.code = b.currency
            LEFT JOIN
                teams t1 ON t1.id = e.teamOne
            LEFT JOIN
                teams t2 ON t2.id = e.teamTwo
            LEFT JOIN 
                total_sum ON b.eventId = total_sum.eventId
            WHERE 
                e.id = ?
            GROUP BY 
                total_sum.eventId
        ", [$id]);
        //return $this->DB()->fetchAll();
        return EventDTO::create($this->DB()->fetchOne());
    }
}