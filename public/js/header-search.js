const searchBtn = document.querySelector('.header-search');
const inputValue = document.querySelector('input[name="search"]');

searchBtn.addEventListener("click", function (event) {
    window.location.href = `/search?value=${inputValue.value}`;
});