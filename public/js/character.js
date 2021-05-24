
const questname = document.querySelector('input[name="name"]');
const lvmin = document.querySelector('input[name="lvmin"]');
const lvmax = document.querySelector('input[name="lvmax"]');
const guild = document.querySelector('input[name="guild"]');

const form = document.querySelector('.search-form');
const characterContainer = document.querySelector('#search-result-container table');

form.addEventListener("submit", function (event) {
    event.preventDefault();
    
    const data = {
        name : questname.value,
        lvmin : lvmin.value,
        lvmax : lvmax.value,
        guild : guild.value,
    };

    fetch("/searchCharacters", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (characters) {

        characters = JSON.parse(characters);

        characterContainer.innerHTML = '<th id="name"><a href="#">Name</th>' +
            '<th id="lv">Level</th>' +
            '<th id="guild">Guild</th>';

        loadCharacters(characters);
    });
    
    show("#search-result-container");
    hide("#comments-container");
});

function loadCharacters(characters) {
    //console.log(items);
    characters.forEach(character => {
        createCharacter(character);
    });
}

function createCharacter(character) {

    const template = document.querySelector("#character-template");

    const clone = template.content.cloneNode(true);


    let nameref = clone.querySelector("#name a");
    nameref.innerHTML = character.name;
    nameref.href = `/character/${character.id}`;

    clone.querySelector("#lv").innerHTML = character.level;

    let guildref = clone.querySelector("#guild a");
    guildref.innerHTML = character.guild.name;
    guildref.href = `/guild/${character.guild.id}`;

    characterContainer.appendChild(clone);
}

function show(name) {
    const container = document.querySelector(name);
    container.style.display = 'inline-block';
}

function hide(name) {
    const container = document.querySelector(name);
    container.style.display = 'none';
}

