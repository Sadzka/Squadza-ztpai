
const editbox = document.querySelector('.comment-editbox');
const commentSubmit = document.querySelector(".button.comment-button");    
const commentContainer = document.querySelector('#comments-container table');
console.log('');

let userId = document.querySelector("#userid");
let userPerms = document.querySelector("#userroles");
userId = userId ? userId.innerHTML : undefined;
userPerms = userPerms ? userPerms.innerHTML : undefined;

if (editbox) {
    editbox.addEventListener("keyup", function (event) {
        const len = this.value.length;
        const maxlen = this.getAttribute('maxlength');
        const rem = maxlen - len;
    
        document.querySelector(".char-remains").innerHTML = "Up to " + maxlen + " characters. " + rem + " characters remaining.";
    })
}

if (commentSubmit) {
    commentSubmit.addEventListener("click", function(event) {
        event.preventDefault();
    
        if (editbox.value.length > 3) {
            let article_id = window.location.pathname.split('/')[2];
    
            data = {
                "article_id" : article_id,
                "comment" : editbox.value
            };
            fetch("/addArticleComment", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(function(response) {
                response = JSON.parse(response);
                response.score = 0;
                response.comment = editbox.value;
                response.editable = 1;
                createComment(response);
                bindStatisticsButtons();
                editbox.value = "";
            })
            .catch(function(error) {
                console.log(error);
            });   
        } 
    });
}

function getArticleComments() {
    let article_id = window.location.pathname.split('/')[2];

    fetch("/getArticleComments/" + article_id, {
        method: "GET",
        headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
        //console.log(response);
        return response.json();
    }).then((response) => {
        response = JSON.parse(response);
        loadComments(response);
    })
    .catch(err => console.log(err));
}

function loadComments(comments) {

    comments.forEach(comment => {
        //console.log(comment );
        createComment(comment);
    });
    bindStatisticsButtons();
    updateCommentUserVotes();
}

function createComment(comment) {
    const template = document.querySelector("#comment-template");

    const clone = template.content.cloneNode(true);

    const score = clone.querySelector(".score");
    score.innerHTML = comment.score ? comment.score : 0;

    const id = clone.querySelector("#comment_id");
    id.id = comment.comment_id;

    clone.querySelector(".comment-header").innerHTML = 'By <a href="#"><span class="user">'
    + comment.author + '</span> <a> on ' + comment.date.date;
    clone.querySelector(".comment-text").innerHTML = comment.content;

    let deleteBtn = clone.querySelector(".comment-delete");

    if (comment.editable || inArray(userPerms, ["ROLE_ADMIN", "ROLE_MOD"])) {
        deleteBtn.style.setProperty('display', 'block');
        deleteBtn.addEventListener('click', function() {
            deleteComment(id.id);
        });
    }

    if (comment.last_edit != null) {
        clone.querySelector(".comment-edit").innerHTML = 'Last edit:' + comment.edit;
    }
    else {
        clone.querySelector(".comment-edit").innerHTML = '';
    }

    //console.log(commentContainer);
    commentContainer.appendChild(clone);
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

function bindStatisticsButtons() {
    votesUp = document.querySelectorAll('.voteup');
    votesDown = document.querySelectorAll('.votedown');
    if (!userId) {
        loginToVote(votesUp);
        loginToVote(votesDown);
        return;
    }
    
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

function loginToVote(array) {
    array.forEach(button => {
        button.addEventListener('click', function (event) {
            alert('Log in to vote!');
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

    fetch(`/setArticleCommentVote`, {
        method: "UPDATE",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (response) {
        response = JSON.parse(response);

        const score = container.querySelector('.score');

        //console.log(response);

        score.innerHTML = response.score;
        
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

function updateCommentUserVotes() {

    const x = document.querySelectorAll('.vote-column');
    var ids = [];

    x.forEach(element => {
        let id = element.getAttribute('id');
        
        fetch(`/getUserArticleCommentVote/${id}`, {
            method: "GET",
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function (response) {
            return response.json();
        }).then(buttons => {
            buttons = JSON.parse(buttons);
            setVoteButtonsCollors(buttons);
        })
        .catch(err => console.log(err));

    });

}

function setVoteButtonsCollors(buttons) {

    var container = document.querySelector("#comments-container");
    var voteColumns = container.querySelectorAll(".vote-column");
    
    //console.log(buttons);
    voteColumns.forEach(column => {
        if (column.getAttribute('id') == buttons.comment_id) {

            //console.log(column.querySelector(".voteup"));

            //console.log(buttons.value)

            let button;
            if (buttons.value == "1")
                button = column.querySelector(".voteup");
            else if (buttons.value == "-1")
                button = column.querySelector(".votedown");
            else
                return;
            changeVoteButtonColors(button);
        }
    });
}

function deleteComment(comment_id) {
    fetch(`/deleteArticleComment/${comment_id}`, {
        method: "DELETE",
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(function(response) {
        response = JSON.parse(response);
        const comments = document.querySelectorAll('.vote-column');

        comments.forEach( comment => {
            if (comment.id == comment_id) {
                comment.parentNode.remove();
            }
        });
    })
    .catch(function(error) {
        console.log(error);
    });   
}

getArticleComments();

