/**
 * Shipping Label
 *
 * @author  Jay Trees <modified-shipping-label@grandels.email>
 * @link    https://github.com/grandeljay/modified-shipping-label
 * @package GrandeljayShippingLabel
 */

"use strict";

function DOMContentLoaded() {
    const observerOptions  = {
        'root'      : null,
        'threshold' : 0
    };
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const textarea = entry.target;

                textarea.setAttribute('readonly', 'readonly');

                const url     = textarea.getAttribute('data-url');
                const options = {
                    'method'  : 'POST',
                    'headers' : {
                        'Content-Type' : 'application/json',
                        'Accept'       : 'text/html',
                    },
                    'body'    : JSON.stringify({
                        'json' : textarea.value
                    })
                };

                fetch(url, options)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Network response was not ok: ${response.status}`);
                        }

                        return response.text();
                    })
                    .then(html => {
                        textarea.style.display = 'none';
                        textarea.insertAdjacentHTML('afterend', html);
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                    })
                    .finally(() => {
                        textarea.removeAttribute('readonly');
                    });
            }
        });
    };
    const observer         = new IntersectionObserver(observerCallback, observerOptions);

    let apiElements = document.querySelectorAll('[data-url]');

    apiElements.forEach(apiElement => {
        observer.observe(apiElement);
    });
}

document.addEventListener('DOMContentLoaded', DOMContentLoaded);

/**
 * Change
 */
function documentChange(event) {
    if (event.target.matches('[data-name]')) {
        let functionElement = event.target.closest('[data-function]');
        let functionName    = functionElement.getAttribute('data-function');
        let functionToCall  = window[functionName];

        if (typeof functionToCall === 'function') {
            functionToCall.call(event.target);
        } else {
            console.error('Function not found:', functionName);
        }
    }
}

document.addEventListener('change', documentChange);

function inputPickPackChange() {
    let table     = this.closest('table');
    let tableRows = table.querySelectorAll('tbody > tr');
    let tableData = [];

    let apiElement = this.closest('details').querySelector('[data-url]');

    tableRows.forEach(tableRow => {
        let inputWeightMax   = tableRow.querySelector('[data-name="weight"]');
        let inputWeightCosts = tableRow.querySelector('[data-name="costs"]');

        if (tableRow.classList.contains('remove')) {
            return;
        }

        tableData.push({
            'weight' : inputWeightMax.value,
            'costs'  : inputWeightCosts.value
        });
    });

    apiElement.value = JSON.stringify(tableData);
}
/** */

/**
 * Click
 */
function documentClick(event) {
    if (event.target.matches('tfoot input[type="button"][data-url]')) {
        inputAddClick.call(event.target);
    }

    if (
        event.target.matches('td button[value="remove"]') ||
        event.target.matches('td button[value="remove"] > img')
    ) {
        inputRemoveClick.call(event.target);
    }
}

document.addEventListener('click', documentClick);

function inputAddClick() {
    const url           = this.getAttribute('data-url');
    const table         = this.closest('table');
    const options       = {
        'method'  : 'GET',
        'headers' : {
            'Content-Type' : 'application/json',
            'Accept'       : 'text/html',
        }
    };

    fetch(url, options)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }

            return response.text();
        })
        .then(html => {
            let tbody = table.querySelector('tbody');

            tbody.insertAdjacentHTML('afterend', html);
        })
        .catch(error => {
            console.error('Fetch error:', error);
        })
        .finally(() => {

        });
}

function inputRemoveClick() {
    const tr          = this.closest('tr');
    const input       = tr.querySelector('[data-name]');
    const eventChange = new Event('change', {
        'bubbles' : true
    });

    tr.classList.add('remove');
    input.dispatchEvent(eventChange);
    tr.style.display = 'none';
}
