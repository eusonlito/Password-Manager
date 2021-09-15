<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap');

/* Reset */

*,
*:before,
*:after {
    box-sizing: border-box;
}

*::before,
*::after {
    content: normal;
}

/* Remove default padding */
ul[class],
ol[class] {
    padding: 0;
}

/* Remove default margin */
body,
h1,
h2,
h3,
h4,
p,
ul,
ol,
li,
figure,
figcaption,
blockquote,
dl,
dd,
a {
    padding: 0;
    margin: 0;
    border: 0;

    line-height: 1.5;
}

/* Set core body defaults */
body {
    min-height: 100vh;
    scroll-behavior: smooth;
    text-rendering: optimizeSpeed;
    line-height: 1.5;
}

/* Remove list styles on ul, ol elements with a class attribute */
ul[class],
ol[class] {
    list-style: none;
}

a {
    text-decoration: none;
    color: inherit;
}

/* A elements that don't have a class get default styles */
a:not([class]) {
    text-decoration-skip-ink: auto;
}

/* Make images easier to work with */
img {
    max-width: 100%;
    display: block;
}

/* Make SVG easier to work with */
svg {
    display: inline-block;
}

/* Inherit fonts for inputs and buttons */
input,
button,
textarea,
select {
    font: inherit;
}

/* End reset */

.pwdmngr-modal {
    -webkit-font-smoothing: antialiased;

    display: flex;
    flex-direction: column;

    width: 100%;
    padding: 0;

    font-family: Roboto, -apple-system, BlinkMacSystemFont, 'Segoe UI', Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    font-size: 16px;
    font-weight: 400;

    line-height: 1.25rem;

    color: hsl(0, 0%, 16%);

    background: hsl(0, 0%, 100%);
    border-radius: 6px;
    box-shadow: 0px 4px 24px -2px rgba(0, 0, 0, 0.08);
}

.pwdmngr-modal__inner {
    direction: ltr; /* Set content back to left-to-right */
}

.pwdmngr-modal__link {
    display: flex;
    align-items: center;

    font-family: inherit;
    font-size: 15px;
    font-weight: 500;

    text-decoration: none;

    color: #4094a5;

    margin: 0 0.5rem;
}

.pwdmngr-modal__link-text {
}

.pwdmngr-modal__link-icon {
    margin-left: 4px;
}

.pwdmngr-modal__header {
    margin: 0;
    display: flex;
    align-items: center;

    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;

    padding: 12px 24px;

    color: inherit;

    background: rgba(241, 245, 248, 0.9);

    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}

.pwdmngr-modal__menu {
    flex-grow: 1;
}

.pwdmngr-modal__menu a,
.pwdmngr-modal__menu svg {
    display: block;
    float: right;
}

.pwdmngr-modal__box {
    padding: 12px 24px;

    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;

    color: inherit;

    background: hsl(0, 0%, 100%);
}

.pwdmngr-modal__input {
    background-color: #FFF;
    box-sizing: border-box;
    border-style: solid;
    border-color: rgba(226, 232, 240, 1);
    font-family: inherit;
    margin: 0.5rem 0;
    color: inherit;
    outline-offset: -2px;
    width: 100%;
    appearance: none;
    border-radius: 0.375rem;
    border-width: 1px;
    padding: 0.375rem 1rem;
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
    line-height: 1.75rem;
    box-shadow: rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0) 0px 0px 0px 0px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
}

.pwdmngr-modal__input:focus {
    outline: 1px solid transparent;
    outline-offset: 1px;
    box-shadow: rgb(255, 255, 255) 0px 0px 0px 0px, rgba(59, 130, 246, 0.5) 0px 0px 0px 2px, rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
}

.pwdmngr-modal__input::placeholder {
    opacity: 1;
    color: #cbd5e0;
}

.pwdmngr-modal__submit {
    width: 100%;
    display: inline-block;
    padding: 0.8em 1.4em;
    border-radius: 0.15em;
    box-sizing: border-box;
    font-weight: 600;
    color: #FFFFFF;
    background-color: #a4aec9;
    box-shadow: inset 0 -0.55em 0 -0.35em rgba(0, 0, 0, 0.17);
    text-align: center;
    border: none;
    cursor: pointer;
    margin: 0.5rem 0;
}

.pwdmngr-modal__submit:active {
    top: 0.1em;
}

.pwdmngr-modal__content {
    max-height: 400px;
    overflow: auto;

    margin: auto 0;

    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;

    color: inherit;

    background: hsl(0, 0%, 100%);
}

.pwdmngr-modal__title {
    margin: 0 0 0 16px;

    font-family: inherit;
    font-size: 18px;
    font-weight: 600;

    color: inherit;
}

ul.pwdmngr-modal__list {
    display: flex;
    flex-direction: column;
    align-items: center;

    margin: 0;
    padding: 12px 24px;

    list-style: none;
    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
}

.pwdmngr-modal__list-heading,
.pwdmngr-modal__list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;

    width: 100%;

    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;
}

.pwdmngr-modal__list-heading {
    font-family: inherit;
    font-size: 13px;
    font-weight: inherit;


    color: hsl(0, 0%, 72%);
}

.pwdmngr-modal__list-item {
    margin-top: 8px;

    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;

    color: inherit;
}

.pwdmngr-modal__list-name {
    width: 56%;

    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;

    font-family: inherit;
    font-size: inherit;

    color: inherit;
}

.pwdmngr-modal__list-option {
    width: 20%;
    margin-left: 16px;

    text-align: center;

    cursor: pointer;
}

.pwdmngr-modal__list-option > svg {
    pointer-events: none;
}

.pwdmngr-modal__preloader,
.pwdmngr-modal__error {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    margin: auto 0;
    padding: 20px 0;

    font-family: inherit;
    font-size: inherit;
    font-weight: inherit;

    text-align: center;

    color: inherit;
}

.pwdmngr-modal__error a {
    color: rgb(64, 148, 165);
}

.pwdmngr-modal__icon {
    padding: 0;
}

.pwdmngr-modal__hidden {
    display: none;
}
</style>