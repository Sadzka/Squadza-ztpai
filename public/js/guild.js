
const guildname = document.querySelector('input[name="name"]');

const form = document.querySelector('.search-form');
const guildContainer = document.querySelector('#search-result-container table');

form.addEventListener("submit", function (event) {
    event.preventDefault();
    
    const data = {
        name : guildname.value,
    };

    fetch("/searchGuilds", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (guilds) {

        guilds = JSON.parse(guilds);

        guildContainer.innerHTML = '<th id="name"><a href="#" class="questref">Name</a></th>' +
            '<th id="members">Members</th>';

        loadGuilds(guilds);
    });
    
    show("#search-result-container");
    hide("#comments-container");
});

function loadGuilds(guilds) {
    //console.log(items);
    guilds.forEach(guild => {
        createGuild(guild);
    });
}

function createGuild(guild) {

    const template = document.querySelector("#character-template");

    const clone = template.content.cloneNode(true);


    let nameref = clone.querySelector("#name a");
    nameref.innerHTML = guild.name;
    nameref.href = `/guild/${guild.id}`;

    clone.querySelector("#members").innerHTML = guild.members;

    guildContainer.appendChild(clone);
}

function show(name) {
    const container = document.querySelector(name);
    container.style.display = 'inline-block';
}

function hide(name) {
    const container = document.querySelector(name);
    container.style.display = 'none';
}

