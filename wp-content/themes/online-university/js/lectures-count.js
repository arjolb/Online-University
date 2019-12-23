let lectures_count = document.querySelectorAll('.lectures-count');
let parentEl = document.querySelector('.content__info--lectures__header p');
let refChild = document.querySelector('.content__info--lectures__header p span');

let total = 0;

if (parentEl && refChild) {
    for (let index = 0; index < lectures_count.length; index++) {
        const element = parseInt(lectures_count[index].innerHTML);
        total+=element;
    }
    
    spanEl = document.createElement('span');
    spanEl.innerHTML = '<i class="fas fa-book"></i> ' + total + (total == 1 ? ' Lesson' : ' Lessons');
    
    parentEl.insertBefore(spanEl,refChild);
}