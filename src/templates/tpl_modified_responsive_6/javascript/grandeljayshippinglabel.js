"use strict";

document.addEventListener('DOMContentLoaded', function() {
    let input_file = document.querySelector('[name="grandeljayshippinglabel-shipping-label"]');

    if (!input_file) {
        return;
    }

    input_file.addEventListener('change', function(event) {
        let form_data  = new FormData();
        form_data.append('grandeljayshippinglabel-shipping-label', input_file.files[0]);

        input_file.setAttribute('disabled', 'disabled');
        input_file.parentElement.querySelector('.text-upload').classList.add('hide');
        input_file.parentElement.querySelector('.text-progress').classList.remove('hide');

        fetch('/api/grandeljay/shipping-label/v1/index.php', {
            'method' : 'POST',
            'body'   : form_data
        })
        .then(response => response.json())
        .then(json => {
            input_file.parentElement.querySelector('.text-upload').classList.add('hide');
            input_file.parentElement.querySelector('.text-progress').classList.add('hide');

            input_file.parentElement.querySelector('.text-success').innerHTML = json.name;
            input_file.parentElement.querySelector('.text-success').classList.remove('hide');
        })
        .finally(() => {
            input_file.removeAttribute('disabled');
        });
    });
});
