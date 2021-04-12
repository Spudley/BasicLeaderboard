(function(w,d) {
    const container = d.getElementById('container');

    let displayLeaderboard = function() {
        if (!container) { return; }
        ajax.loadEntries(function(response) {
            let entries = response.data;
            container.innerHTML = renderer.renderEntries(entries);
        }, function() {
            alert('Error loading entries');
        });
    };

    let ajax = {
        loadEntries: function(successHandler, errorHandler) {
            this.call('GET', './api/topScores', {quantity:5}, successHandler, errorHandler);
        },
        createEntry: function(data, successHandler, errorHandler) {
            this.call('POST', './api/entry', data, successHandler, errorHandler);
        },
        updateEntry: function(data, successHandler, errorHandler) {
            this.call('PATCH', './api/entry', data, successHandler, errorHandler);
        },
        deleteEntry: function(data, successHandler, errorHandler) {
            this.call('DELETE', './api/entry', data, successHandler, errorHandler);
        },

        call: function(method, url, data, successHandler, errorHandler) {
            if (method === 'GET') {
                url += '?' + Object.keys(data).map(function(key) {return key+'='+data[key];}).join('&');
            }
            let xhr = new XMLHttpRequest();
            xhr.open(method, url);
            if (method === 'GET') {
                xhr.send();
            } else {
                xhr.send(JSON.stringify(data));
            }

            xhr.onload = function() {
                let response = {};
                if (xhr.status == 200) {
                    response = JSON.parse(xhr.response);
                }
                if (response.result == 'success') {
                    successHandler(response);
                } else {
                    errorHandler(response);
                }
            };

            xhr.onerror = function() {
                errorHandler({'message': 'An error occurred'}); //better error handling obviously required here.
            };
        }
    };

    let eventHandler = {
        setup: function() {
            let handler = this;
            d.querySelectorAll('.btn').forEach(function(button) {
                let eventName = button.id.replace('btn_','');
                button.addEventListener('click', handler[eventName]);
            });
        },

        create: function(event) {
            console.log('create clicked!');
            let data = {
                'username': d.getElementById('c_username').value,
                'score': d.getElementById('c_score').value
            };
            ajax.createEntry(data, function() {
                alert('New entry created.');
            }, function() {
                alert('Error creating entry!');
            });
        },

        update: function(event) {
            console.log('update clicked!');
            let data = {
                'username': d.getElementById('u_username').value,
                'score': d.getElementById('u_score').value
            };
            ajax.updateEntry(data, function(response) {
                alert('Entry updated.');
            }, function() {
                alert('Error updating entry!');
            });
        },

        remove: function(event) {   //'remove' because 'delete' is a JavaScript keyword
            console.log('delete clicked!');
            let data = {
                'username': d.getElementById('d_username').value
            };
            ajax.deleteEntry(data, function(response) {
                alert('Entry deleted.');
            }, function() {
                alert('Error deleting entry!');
            });
        }
    };

    let renderer = {
        renderEntries: function(entries) {
            let tableRows = [];
            entries.forEach(function(entry) {
                let row = "<tr>"
                        + "<td>"+entry.username+"</td>"
                        + "<td>"+entry.score+"</td>"
                        + "</tr>";
                tableRows.push(row);
            });

            return "<table>"
                 + "<tr><th>Username</th><th>Score</th></tr>"
                 + tableRows.join('')
                 + "</table>";
        },
    }

    eventHandler.setup();
    displayLeaderboard();
})(window, document);
