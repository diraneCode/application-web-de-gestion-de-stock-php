const form = document.querySelector('.formUpdate');
const btn = document.querySelector('.formUpdate .btn');

const tab = document.querySelectorAll('.btn-modifier');
tab.forEach((btn) => {
    btn.addEventListener('click', () => {
        form.classList.add('show');
        let id = btn.getAttribute('data-id');
        document.querySelector('#stockID').value = id;
        // alert(id);
    })
})

btn.addEventListener('click', () =>{
    form.classList.remove('show');
})