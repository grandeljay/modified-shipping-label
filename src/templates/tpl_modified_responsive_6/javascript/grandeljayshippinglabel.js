"use strict";

document.addEventListener('DOMContentLoaded', function() {
    let input_file = document.querySelector('[name="grandeljayshippinglabel-shipping-label[]"]');

    if (!input_file) {
        return;
    }

    input_file.addEventListener('change', function(event) {
        let form_data = new FormData();

        for (let index = 0; index < input_file.files.length; index++) {
            const file = input_file.files[index];

            form_data.append('grandeljayshippinglabel-shipping-label[]', file);
        }

        input_file.setAttribute('disabled', 'disabled');
        input_file.parentElement.querySelector('.text-upload').classList.add('hide');
        input_file.parentElement.querySelector('.text-progress').classList.remove('hide');
        input_file.parentElement.querySelector('.text-success').classList.add('hide');

        fetch('/api/grandeljay/shipping-label/v1/index.php', {
            'method' : 'POST',
            'body'   : form_data
        })
        .then(response => response.json())
        .then(json => {
            input_file.parentElement.querySelector('.text-upload').classList.add('hide');
            input_file.parentElement.querySelector('.text-progress').classList.add('hide');

            input_file.parentElement.querySelector('.text-success').innerHTML = '';
            json.labels.forEach(label => {
                input_file.parentElement.querySelector('.text-success').innerHTML += label.name + '<br>';
            });

            input_file.parentElement.querySelector('.text-success').classList.remove('hide');
        })
        .catch(error => {
            console.log(error);

            input_file.parentElement.querySelector('.text-progress').classList.add('hide');
            input_file.parentElement.querySelector('.text-failure').innerHTML = "Check console for detailed error";
            input_file.parentElement.querySelector('.text-failure').classList.remove('hide');
        })
        .finally(() => {
            input_file.removeAttribute('disabled');
        });
    });
});
