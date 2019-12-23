let mobile_navigation = document.querySelector('#mobile_navigation');

let dropdown = document.querySelectorAll('.site-header__nav--links__subjects');



mobile_navigation.addEventListener('change',function(){
    var link = mobile_navigation.options[mobile_navigation.selectedIndex].value;

    if (link=='#') {
        return ;
    }

    location.href = link;
});

for (let index = 0; index < dropdown.length; index++) {
    dropdown[index].addEventListener('click',function(e){
        e.preventDefault();
    });
    
}