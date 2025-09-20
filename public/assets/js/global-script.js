window.addEventListener('DOMContentLoaded', () => {

    // loading icon element
    const loadingIcon = document.createElement('i');
    loadingIcon.classList.add("fa-solid", "fa-spinner-third", "fa-spin");

    function name(params) {
        
    }

    // handle form submit with ajax
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // disabled button
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.disabled = true;
                button.appendChild(loadingIcon);
            }

            // dapatkan form input
            let formInput = e.target.querySelectorAll('input');
            let formData = {};
            formInput.forEach((input) => {
                formData[input.getAttribute('name')] = input.value;
            });

            // alert element
            let alert = e.target.querySelector('.alert.alert-danger');
            if (alert) {
                alert.innerHTML = "";
                alert.classList.add('d-none');
            }

            fetch(form.getAttribute('action') || currentURL, {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(async (data) => {
                    if (data.error && alert) {
                        alert.innerHTML = data.error;
                        alert.classList.remove('d-none');

                        return;
                    }

                    if (data.success) {
                        for (let time = 3; time >= 0; time--) {
                            await new Promise((resolve, reject) => setTimeout(resolve, 1000));
                            button.innerHTML =  `Redirecting in ${time}...`
                        }

                        window.location.assign(data.redirect_to);
                        return
                    }

                    if (button) {
                        button.querySelector('.fa-spinner-third').remove();
                        button.disabled = false;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });

        });
    });
});