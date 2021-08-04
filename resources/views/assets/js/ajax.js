window.ajax = function (href, body, callback) {
    if (typeof body === 'function') {
        callback = body;
        body = null;
    }

    return fetch(href, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: (body ? JSON.stringify(body) : null)
    }).then(async response => {
        const text = await response.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch (err) {
            return alert(text);
        }

        if (!response.ok) {
            return alert(data.message);
        }

        return callback(data, body);
    })
    .catch(error => alert(error.message));
};