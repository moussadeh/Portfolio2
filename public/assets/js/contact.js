const formContact = document.querySelector('#form-contact');
let lockAction = false;
if (formContact) {
    formContact.addEventListener('submit', (e) => {
        e.preventDefault();
        sendMail(formContact, new FormData(formContact));
    });
}

const sendMail = async (form, FormData) => {
    // trigger => le déclencheur
    if (lockAction == false) {
        lockAction == true;
        Notiflix.Loading.circle();
        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: FormData,
            });
            const data = await response.json();
            Notiflix.Loading.remove();
            if ((response.status == 200 || response.ok) && data.success == true) {
                Notiflix.Notify.success(data.message);
                formContact.reset();
                return true;
            } else {
                if (data.message) {
                    Notiflix.Notify.failure(data.message);
                }
                return false;
                // throw new Error(`An error has occured: ${response.status}`);
            }
        } catch (error) {
            Notiflix.Loading.remove();
            console.error(error);
            return false;
        }
    }else{
        return false;
    }
};
//# sourceMappingURL=contact.js.map