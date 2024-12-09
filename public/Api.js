class Api {
    constructor(baseURL = '') {
        this.baseURL = baseURL; // Базовый URL, если нужен
    }

    request(url, method = 'GET', data = null, headers = {}) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open(method, this.baseURL + url, true);

            // Устанавливаем заголовки
            xhr.setRequestHeader('Content-Type', 'application/json');
            for (const [key, value] of Object.entries(headers)) {
                xhr.setRequestHeader(key, value);
            }

            // Обработка ответа
            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        resolve(response);
                    } catch (e) {
                        resolve(xhr.responseText);
                    }
                } else {
                    reject({
                        status: xhr.status,
                        statusText: xhr.statusText,
                        response: JSON.parse(xhr.responseText),
                    });
                }
            };

            xhr.onerror = () => {
                reject({
                    status: xhr.status,
                    statusText: xhr.statusText,
                });
            };

            // Отправляем данные
            if (data) {
                xhr.send(JSON.stringify(data));
            } else {
                xhr.send();
            }
        });
    }

    get(url, headers = {}) {
        return this.request(url, 'GET', null, headers);
    }

    post(url, data, headers = {}) {
        return this.request(url, 'POST', data, headers);
    }

    put(url, data, headers = {}) {
        return this.request(url, 'PUT', data, headers);
    }

    delete(url, headers = {}) {
        return this.request(url, 'DELETE', null, headers);
    }
}
