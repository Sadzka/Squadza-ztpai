
function updateStatisticsButtons() {
    votesUp = document.querySelectorAll('.voteup');
    votesDown = document.querySelectorAll('.votedown');
    
    votesUp.forEach(button => {
        button.addEventListener('click', function (event) {
            vote(button, '1');
        });
    });

    votesDown.forEach(button => {
        button.addEventListener('click', function (event) {
            vote(button, '-1');
        });
    });
}

function vote(button, value) {
    const container = button.parentElement;
    const id = container.getAttribute('id');
    
    const data = {
        comment_id : id,
        value : value
    };

    fetch("/setItemCommentVote", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (response) {
        if (response.err) {
            alert(response.err);
            return;
        }
        const score = container.querySelector('.score');
        score.innerHTML = response.score ? parseInt(response.score) : 0 ;
        
        changeVoteButtonColors(button);

    }).catch(err => console.log(err));
}

function changeVoteButtonColors(button) {

    const voteup = button.parentElement.querySelector(".voteup");
    const votedown = button.parentElement.querySelector(".votedown");

    if (voteup == button) {
        if (voteup.classList.contains('clicked')) {
            voteup.classList.remove('clicked');
        }
        else {
            voteup.classList.add('clicked');
            votedown.classList.remove('clicked');
        }
    }
    if (votedown == button) {
        if (votedown.classList.contains('clicked')) {
            votedown.classList.remove('clicked');
        }
        else {
            votedown.classList.add('clicked');
            voteup.classList.remove('clicked');
        }
    }
}

function setVoteButtonsCollors(buttons) {

    var container = document.querySelector("#comments-container");
    var voteColumns = container.querySelectorAll(".vote-column");

    if (buttons) {
        buttons.forEach(element => {
    
            voteColumns.forEach(column => {
                //console.log(column)
                if (column.getAttribute('id') == element.items_comment_id) {
    
                    //console.log(column.querySelector(".voteup"));
    
                    var button = (element.positive ==  "1") 
                    ? column.querySelector(".voteup")
                    : column.querySelector(".votedown");
                    //console.log(button);
                    changeVoteButtonColors(button);
                }
            });
    
        });
    }
}

function updateCommentUserResponse() {

    const x = document.querySelectorAll('.vote-column');
    var ids = [];

    x.forEach(element => {
        ids.push( element.getAttribute('id') );
    });

    const data = {
        comment_ids : ids,
    };

    fetch("/getItemCommentsResponse", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (buttons) {
        setVoteButtonsCollors(buttons);
    }).catch(err => console.log(err));
}