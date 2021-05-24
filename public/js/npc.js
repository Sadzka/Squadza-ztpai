
const npcname = document.querySelector('input[name="name"]');
const reqlvmin = document.querySelector('input[name="reqlvmin"]');
const reqlvmax = document.querySelector('input[name="reqlvmax"]');
const locationname = document.querySelector('input[name="location"]');

const form = document.querySelector('.search-form');
const npcContainer = document.querySelector('#search-result-container table');

form.addEventListener("submit", function (event) {
    event.preventDefault();
    
    const data = {
        name : npcname.value,
        lvmin : reqlvmin.value,
        lvmax : reqlvmax.value,
        locationname : locationname.value
    };

    fetch("/searchNpcs", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (npcs) {
        npcs = JSON.parse(npcs);
        let parsed_npcs = []
        npcs.forEach(function(npc) {
            parsed_npcs.push( JSON.parse(npc) );
        });

        npcContainer.innerHTML = "<tr>" +
            "<th>Name</th>" +
            "<th>Level</th>" +
            "<th>Health</th>" +
            "<th>Friendly</th>" +
            "<th>Location</th>" +
            "</tr>";

        loadNpcs(parsed_npcs);
    });
    
    show("#search-result-container");
    hide("#comments-container");
});

function loadNpcs(npcs) {
    npcs.forEach(npc => {
        createNpc(npc);
    });
}

function createNpc(npc) {

    const template = document.querySelector("#npc-template");

    const clone = template.content.cloneNode(true);

    let npcref = clone.querySelector("#nname a");
    npcref.innerHTML = npc.name;
    npcref.href = `/npc/${npc.id}`;

    clone.querySelector("#loc").innerHTML =
        `<a class="npcref" href=/location/${npc.location.id}?x=${npc.x}&y=${npc.y}>${npc.location.name} <br> (${npc.x}, ${npc.y})</a>`;
    clone.querySelector("#lv").innerHTML = npc.level;
    clone.querySelector("#hp").innerHTML = npc.health;
    clone.querySelector("#fr").innerHTML = npc.friendly;

    npcContainer.appendChild(clone);
}

function show(name) {
    const container = document.querySelector(name);
    container.style.display = 'inline-block';
}

function hide(name) {
    const container = document.querySelector(name);
    container.style.display = 'none';
}

