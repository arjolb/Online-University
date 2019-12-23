//Variables
let lecture = document.querySelectorAll('.content__sidebar--upcoming-events-content__lecture');
let extraContent = '.content__sidebar--upcoming-events-content__extra--id-';
let toggleBtn = document.querySelectorAll('.toggle');
let toggle = '.toggle-';


//Events
for (let i = 0; i < lecture.length; i++) {
    lecture[i].addEventListener('click',toggleExtra);
}

for (let i = 0; i < toggleBtn.length; i++) {
    toggleBtn[i].addEventListener('click',toggleExtra);
}


//Functions
function toggleExtra(e) {
    let id = this.getAttribute('data-id');
    let extraContentEl = document.querySelector(extraContent+id);
    extraContentEl.classList.toggle('active');
}