var menuBtn = document.querySelector('.menu-btn');
var burger = document.querySelector('.burger');
var lineOne = document.querySelector('.burger .menu-btn .line--1');
var lineTwo = document.querySelector('.burger .menu-btn .line--2');
var lineThree = document.querySelector('.burger .menu-btn .line--3');
var link = document.querySelector('.burger .nav-links');
menuBtn.addEventListener('click', () => {
    burger.classList.toggle('nav-open');
    lineOne.classList.toggle('line-cross');
    lineTwo.classList.toggle('line-fade-out');
    lineThree.classList.toggle('line-cross');
    link.classList.toggle('fade-in');
});
