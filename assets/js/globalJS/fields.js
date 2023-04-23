// not_empty
const classNotEmpty = 'not_empty';
const fields = document.querySelectorAll('.field__input, .field__textarea');
fields.forEach(field => {
    // console.log(field);
    field.addEventListener('keydown', (e) => {
        if (e.target.value != '') {
            e.target.classList.add(classNotEmpty);
        } else {
            e.target.classList.remove(classNotEmpty);
        }
    });
});
