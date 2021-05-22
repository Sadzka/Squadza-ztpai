
const questname = document.querySelector('input[name="name"]');
const reqlvmin = document.querySelector('input[name="reqlvmin"]');
const reqlvmax = document.querySelector('input[name="reqlvmax"]');const itemname = document.querySelector('input[name="name"]');

const form = document.querySelector('.search-form');
const questContainer = document.querySelector('#search-result-container table');

form.addEventListener("submit", function (event) {
    event.preventDefault();
    
    const data = {
        name : questname.value,
        reqlvmin : reqlvmin.value,
        reqlvmax : reqlvmax.value,
    };

    fetch("/searchQuests", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (quests) {
        quests = JSON.parse(quests);
        let parsed_quests = []
        quests.forEach(function(quest) {
            parsed_quests.push( JSON.parse(quest) );
        });
        //console.log(parsed_quests);

        questContainer.innerHTML = "<tr><th>Name</th><th>Required Level</th><th>Start</th><th>End</th><th>Rewards</th></tr>";

        loadQuests(parsed_quests);
    });
    
    show("#search-result-container");
    hide("#comments-container");
});

function loadQuests(quests) {
    //console.log(items);
    quests.forEach(quest => {
        createQuest(quest);
    });
}

function createQuest(quest) {

    const template = document.querySelector("#quest-template");

    const clone = template.content.cloneNode(true);

    clone.querySelector("#rlv").innerHTML = quest.reqlv;
    clone.querySelector("#end").innerHTML = `<a href="/npc/${quest.end_npc_id}" class="npcref">` + quest.end_npc_name + '</a>';
    setGoldReward(quest.rewards, clone.querySelector("#rewards"));
    //.innerHTML = quest.rewards;

    let questref = clone.querySelector("#qname a");
    questref.innerHTML = quest.name;
    questref.href = `/quest/${quest.id}`;

    let startNpc = clone.querySelector("#start a");
    startNpc.innerHTML = quest.start_npc_name;
    startNpc.href = `/npc/${quest.start_npc_id}`;

    let endNpc = clone.querySelector("#end a");
    endNpc.innerHTML = quest.end_npc_name;
    endNpc.href = `/npc/${quest.end_npc_id}`;

    questContainer.appendChild(clone);
}

function setGoldReward(ammount, element) {
    ammount = parseInt(ammount);

    let gold = (ammount/10000 % 100).toFixed(0);
    if (gold != 0)
        element.querySelector(".m-gold").innerHTML = gold + " ";

    let silver = (ammount/100 % 100).toFixed(0);
    if (silver != 0)
        element.querySelector(".m-silver").innerHTML = silver + " ";

    let copper = (ammount % 100).toFixed(0);
    if (copper != 0)
        element.querySelector(".m-copper").innerHTML = copper;
}

function show(name) {
    const container = document.querySelector(name);
    container.style.display = 'inline-block';
}

function hide(name) {
    const container = document.querySelector(name);
    container.style.display = 'none';
}

