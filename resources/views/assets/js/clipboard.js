window.clipboard = function (text) {
    const element = document.createElement('textarea');

    element.style = 'position: absolute; width: 1px; height: 1px; left: -10000px; top: -10000px';
    element.value = text;

    document.body.appendChild(element);

    element.select();
    element.setSelectionRange(0, 99999);

    document.execCommand('copy');

    document.body.removeChild(element);
}