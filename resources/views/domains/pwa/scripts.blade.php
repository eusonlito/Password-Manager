<script>
(function() {
    this.DEBUG = false;

    this.ENDPOINT = '{{ config('app.url') }}';
    this.APIKEY = '';

    this.ICON_APIKEY = 'icon-apikey';
    this.ICON_WARNING = 'icon-warning';
    this.ICON_NO_RESULTS = 'icon-no-results';

    this.log = function() {
        if (this.DEBUG) {
            Array.prototype.slice.call(arguments).forEach(element => console.log(element));
        }
    };

    this.$modal = function() {
        return document.getElementById('js-pwdmngr-modal');
    };

    this.$header = function() {
        return document.getElementById('js-pwdmngr-header');
    };

    this.$home = function() {
        return document.getElementById('js-pwdmngr-home');
    };

    this.$menu = function() {
        return document.getElementById('js-pwdmngr-menu');
    };

    this.$search = function() {
        return document.getElementById('js-pwdmngr-search');
    };

    this.$searchSubmit = function() {
        return document.getElementById('js-pwdmngr-search-submit');
    };

    this.$content = function() {
        return document.getElementById('js-pwdmngr-content');
    };

    this.$apiSecret = function() {
        return document.getElementById('js-pwdmngr-api-secret');
    };

    this.$apiSecretSubmit = function() {
        return document.getElementById('js-pwdmngr-api-secret-submit');
    };

    this.$config = function() {
        return document.getElementById('js-pwdmngr-config');
    };

    this.$configSubmit = function() {
        return document.getElementById('js-pwdmngr-config-submit');
    };

    this.showError = function(message, icon) {
        let iconTPL = '';

        switch (icon) {
            case this.ICON_APIKEY:
                iconTPL = pwdmngrTemplates('ICON_APIKEY');
                break;

            case this.ICON_WARNING:
                iconTPL = pwdmngrTemplates('ICON_WARNING');
                break;

            case this.ICON_NO_RESULTS:
                iconTPL = pwdmngrTemplates('ICON_NO_RESULTS');
                break;
        }

        this.$content().innerHTML = `
            <p class="pwdmngr-modal__error">
                <span class="pwdmngr-modal__icon">${ iconTPL }</span>
                ${ message }
            </p>
        `;
    };

    this.showCredentialList = function(credentialList) {
        this.log('[password-manager] Showing User List', credentialList);

        this.$content().innerHTML = `
            <ul class="pwdmngr-modal__list">`
                + this.showCredentialListHeader()
                + credentialList.map(item => this.showCredentialListItem(item)).join('')
            + `</ul>`;

        this.$content().querySelectorAll('[data-credential]').forEach(item => {
            item.addEventListener('click', () => this.copy(item));
        });
    };

    this.showCredentialListHeader = function() {
        return `<li class="pwdmngr-modal__list-heading">`
            + `<span class="pwdmngr-modal__list-name">CREDENTIAL</span>`
            + `<span class="pwdmngr-modal__list-option">USER</span>`
            + `<span class="pwdmngr-modal__list-option">PASSWORD</span>`
            + `</li>`;
    };

    this.showCredentialListItem = function(item) {
        return `<li class="pwdmngr-modal__list-item">`
            + `<span class="pwdmngr-modal__list-name">${ item.name }</span>`
            + `<span class="pwdmngr-modal__list-option" data-credential data-credential-id="${ item.id }" data-credential-type="user">${ pwdmngrTemplates('ICON_COPY') }</span>`
            + `<span class="pwdmngr-modal__list-option" data-credential data-credential-id="${ item.id }" data-credential-type="password">${ pwdmngrTemplates('ICON_COPY') }</span>`
            + `</li>`
    };

    this.showStorageError = function() {
        this.$search().classList.add('pwdmngr-modal__hidden');
        this.showError('You must enabled cookies to use this app.', ICON_WARNING);
    };

    this.home = function(e) {
        e.preventDefault();

        this.showContent();
    };

    this.menu = function(e) {
        e.preventDefault();

        if (this.$content().classList.contains('pwdmngr-modal__hidden')) {
            this.showContent();
        } else {
            this.showConfig();
        }
    };

    this.showContent = function() {
        this.$apiSecret().classList.add('pwdmngr-modal__hidden');
        this.$config().classList.add('pwdmngr-modal__hidden');
        this.$search().classList.remove('pwdmngr-modal__hidden');
        this.$content().classList.remove('pwdmngr-modal__hidden');
    };

    this.showConfig = function() {
        this.$apiSecret().classList.add('pwdmngr-modal__hidden');
        this.$search().classList.add('pwdmngr-modal__hidden');
        this.$content().classList.add('pwdmngr-modal__hidden');
        this.$config().classList.remove('pwdmngr-modal__hidden');
    };

    this.showApiSecret = function() {
        this.$config().classList.add('pwdmngr-modal__hidden');
        this.$search().classList.add('pwdmngr-modal__hidden');
        this.$content().classList.add('pwdmngr-modal__hidden');
        this.$apiSecret().classList.remove('pwdmngr-modal__hidden');
    };

    this.configSubmit = function(e) {
        e.preventDefault();

        const credentials = {};

        this.$config().querySelectorAll('input').forEach(element => {
            credentials[element.name] = element.value;
        });

        this.storageSet('credentials', credentials);

        this.showContent();
        this.setConfig();
    };

    this.apiSecretSubmit = function(e) {
        e.preventDefault();

        const query = {};

        this.$apiSecret().querySelectorAll('input').forEach(element => {
            query[element.name] = element.value;
        });

        this.$search().querySelectorAll('input').forEach(element => {
            query[element.name] = element.value;
        });

        this.showContent();
        this.apiSearch(query);
    };

    this.request = async function(url, body) {
        this.log('[password-manager] requesting Data');

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': this.APIKEY
            },
            body: JSON.stringify(body)
        });

        const text = await response.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch (e) {
            return this.showError('Can not load url ' + url + ': ' + text, this.ICON_WARNING);
        }

        if (response.ok) {
            return data;
        }

        if (data.status === 'api_secret_required') {
            return this.showApiSecret();
        }

        return this.showError('Can not load url ' + url + ': ' + data.message + '', this.ICON_WARNING);
    };

    this.apiSearch = async function(query) {
        this.$content().innerHTML = `<div class="pwdmngr-modal__preloader">${ pwdmngrTemplates('PRELOADER') }</div>`;

        this.log('[password-manager] Checking credentials...');

        const data = await this.request(this.ENDPOINT + '/app/api/search', query);

        if (!data) {
            return;
        }

        if (!data.length) {
            return this.showError(`<span>No results :(</span>`, this.ICON_NO_RESULTS)
        }

        this.showCredentialList(data);
    };

    this.searchSubmit = function(e) {
        const query = {};

        this.$search().querySelectorAll('input').forEach(element => {
            query[element.name] = element.value;
        });

        if (this.filter(query).length) {
            this.apiSearch(query);
        }
    };

    this.clipboard = function(text) {
        const element = document.createElement('textarea');

        element.style = 'position: absolute; width: 1px; height: 1px; left: -10px; top: -10px';
        element.value = text;

        document.body.appendChild(element);

        element.select();
        element.setSelectionRange(0, 99999);

        document.execCommand('copy');

        document.body.removeChild(element);
    };

    this.copy = async function(el) {
        const data = await this.request(this.ENDPOINT + '/app/api/' + el.dataset.credentialId + '/payload/' + el.dataset.credentialType);

        if (!data) {
            return;
        }

        this.clipboard(this.decode(data.value));

        const text = el.innerHTML;

        el.innerHTML = 'Copied!';

        setTimeout(() => el.innerHTML = text, 1000);
    };

    this.decode = function(encoded) {
        const hex = atob(encoded).split('\\x');
        let decoded = '';

        for (let i = 0; i < hex.length; i++) {
            decoded += this.hex2char(hex[i]);
        }

        return decoded;
    };

    this.hex2char = function(hex) {
        const groups = hex.match(/[\s\S]{2}/g) || [];
        let char = '';

        for (var i = 0, j = groups.length; i < j; i++) {
            char += '%' + ('0' + groups[i]).slice(-2);
        }

        return decodeURIComponent(char);
    };

    this.events = function() {
        this.$configSubmit().addEventListener('click', e => this.configSubmit(e));
        this.$searchSubmit().addEventListener('click', e => this.searchSubmit(e));
        this.$menu().addEventListener('click', e => this.menu(e));
        this.$home().addEventListener('click', e => this.home(e));
        this.$apiSecretSubmit().addEventListener('click', e => this.apiSecretSubmit(e));
    };

    this.setConfig = function() {
        const credentials = this.storageGet('credentials');

        if (!credentials || !credentials.apikey) {
            return this.showConfig();
        }

        this.APIKEY = credentials.apikey;

        this.log('[password-manager] Setting Configuration');
        this.log('[password-manager] APIKEY', this.APIKEY);
    };

    this.storageEnabled = function() {
        try {
            localStorage.setItem('local-storage-test', Math.random());
            localStorage.removeItem('local-storage-test');
        } catch (e) {
            return false
        }

        return true;
    };

    this.storageGet = function(key) {
        let value = localStorage.getItem(key);

        if (value) {
            return JSON.parse(value);
        }
    };

    this.storageSet = function(key, value) {
        localStorage.setItem(key, JSON.stringify(value));

        return value;
    };

    this.filter = function(data) {
        if (!data) {
            return null;
        }

        if (Array.isArray(data) === false) {
            data = Object.values(data);
        }

        return data.filter(value => value && value.length);
    };

    this.init = function(request) {
        if (this.storageEnabled() === false) {
            return this.showStorageError();
        }

        this.events();
        this.setConfig();
    };

    this.init();
})();

function pwdmngrTemplates(name) {
    switch (name) {
        case 'ICON_COPY':
            return `
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.8 3h1.4a2.3 2.3 0 012.3 2.3v15a2.3 2.3 0 01-2.3 2.2H6.8a2.3 2.3 0 01-2.3-2.3v-15A2.2 2.2 0 016.8 3h1.5" stroke="#7BBFCC" stroke-width="1.5" stroke-linejoin="round"/><path d="M14.5 1.5h-5c-.7 0-1.3.5-1.3 1.2v.6c0 .7.6 1.2 1.3 1.2h5c.7 0 1.3-.5 1.3-1.2v-.6c0-.7-.6-1.2-1.3-1.2z" stroke="#7BBFCC" stroke-width="1.5" stroke-linejoin="round"/></svg>
            `;

        case 'ICON_WARNING':
            return `
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 41.8h32a3 3 0 002.6-4.4l-16-29.7a3 3 0 00-5.2 0l-16 29.7A3 3 0 008 41.8v0z" stroke="#F7B73B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.5 18.3l.5 11.5.5-11.5a.5.5 0 00-.5-.5v0a.5.5 0 00-.5.5v0z" fill="#F7B73B" stroke="#F7B73B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 36.6l-.7-.2-.4-.6a1.1 1.1 0 01.2-1.2l.7-.4.7.1.5.4a1.1 1.1 0 01-.1 1.5c-.3.2-.6.4-.9.4z" fill="#F7B73B"/></svg>
            `;

        case 'ICON_APIKEY':
            return `
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 15.2c0 1.2 0 2.4.3 3.5-4 4.7-14.7 17.3-15.7 18.2a1.9 1.9 0 00-.6 1.4c0 .8.5 1.6.9 2 .6.7 3.3 3.1 3.8 2.6l2.3-2.3c.9-.9-.1-2.7.2-3.4.3-.7.6-.9 1.2-1 .5 0 1.4.3 2.2.3.8 0 1.2-.3 1.8-.9.4-.4.8-.8.8-1.4 0-.9-1.2-2-.3-2.9.9-.9 2.2.6 3.2.5 1-.1 2.1-1.4 2.2-2 .2-.6-1-2-.9-2.9 0-.3.7-1 1.1-1 .4-.1 2.3.6 2.8.5.5 0 1.1-.6 1.6-1A11.4 11.4 0 0044 15.1C44 9 38.8 4 32.4 4 26 4 20.9 9 20.9 15.2zM38 13a3 3 0 11-6 0 3 3 0 016 0z" stroke="#EC5757" stroke-width="2" stroke-linejoin="round"/></svg>
            `;

        case 'ICON_NO_RESULTS':
            return `
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M36.4 34.5a18.4 18.4 0 10-2 1.9l7.8 7.6s.7.1 1.3-.5c.6-.6.5-1.3.5-1.3l-7.6-7.7zm-2.8-.9a15.8 15.8 0 114.7-11.2c0 4.2-1.7 8.3-4.7 11.2z" fill="#4095A5"/></svg>
            `;

        case 'PRELOADER':
            return `
                <svg width="48" height="48" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg" stroke="#4094a5">
                    <g fill="none" fill-rule="evenodd">
                        <g transform="translate(1 1)" stroke-width="2">
                            <circle cx="5" cy="50" r="5">
                                <animate attributeName="cy"
                                     begin="0s" dur="2.2s"
                                     values="50;5;50;50"
                                     calcMode="linear"
                                     repeatCount="indefinite" />
                                <animate attributeName="cx"
                                     begin="0s" dur="2.2s"
                                     values="5;27;49;5"
                                     calcMode="linear"
                                     repeatCount="indefinite" />
                            </circle>
                            <circle cx="27" cy="5" r="5">
                                <animate attributeName="cy"
                                     begin="0s" dur="2.2s"
                                     from="5" to="5"
                                     values="5;50;50;5"
                                     calcMode="linear"
                                     repeatCount="indefinite" />
                                <animate attributeName="cx"
                                     begin="0s" dur="2.2s"
                                     from="27" to="27"
                                     values="27;49;5;27"
                                     calcMode="linear"
                                     repeatCount="indefinite" />
                            </circle>
                            <circle cx="49" cy="50" r="5">
                                <animate attributeName="cy"
                                     begin="0s" dur="2.2s"
                                     values="50;50;5;50"
                                     calcMode="linear"
                                     repeatCount="indefinite" />
                                <animate attributeName="cx"
                                     from="49" to="49"
                                     begin="0s" dur="2.2s"
                                     values="49;5;27;49"
                                     calcMode="linear"
                                     repeatCount="indefinite" />
                            </circle>
                        </g>
                    </g>
                </svg>
            `;
    }
}
</script>