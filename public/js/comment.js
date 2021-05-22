
const editbox = document.querySelector('.comment-editbox');
const commentSubmit = document.querySelector(".button.comment-button");    
const commentCancel = document.querySelector(".button.comment-button.comment-cancel");
const commentContainer = document.querySelector('#comments-container table');

let userId = document.querySelector("#userid");
let userPerms = document.querySelector("#userroles");
userId = userId ? userId.innerHTML : undefined;
userPerms = userPerms ? userPerms.innerHTML : undefined;

const comment_type = document.querySelector("#comment_type").innerHTML;

let editing_id = -1;

if (editbox) {
    editbox.addEventListener("keyup", function (event) {
        const len = this.value.length;
        const maxlength = this.getAttribute('maxlength');
        const rem = maxlength - len;
    
        document.querySelector(".char-remains").innerHTML = "Up to " + maxlength + " characters. " + rem + " characters remaining.";
    })
}

if (commentSubmit) {
    commentSubmit.addEventListener("click", function(event) {
        event.preventDefault();

        if (editbox.value.length > 3) {

            let type_id = window.location.pathname.split('/')[2];

            if (editing_id != -1) {
                let data = {
                    "comment" : editbox.value
                };
                fetch(`/editComment/${editing_id}`, {
                    method: "PUT",
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(function(response) {
                    response = JSON.parse(response);
                    const comments = document.querySelectorAll('.vote-column');
                    comments.forEach( comment => {
                        if (comment.id == editing_id) {
                            let starttime = new Date();
                            let isotime = new Date((new Date(starttime)).toISOString() );
                            let fixedtime = new Date(isotime.getTime()-(starttime.getTimezoneOffset()*60000));
                            let formatedMysqlString = fixedtime.toISOString().slice(0, 19).replace('T', ' ');
                            comment.parentNode.querySelector(".comment-text").innerHTML = editbox.value;
                            comment.parentNode.querySelector(".comment-edit").innerHTML = `Last edit: ${formatedMysqlString}`;
                        }
                    });
                    cancelEdition();
                })
                .catch(function(error) {
                    console.log(error);
                });
                return;
            }


            let data = {
                "type_id" : type_id,
                "comment" : editbox.value
            };
            fetch(`/addComment/${comment_type}`, {
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

if (commentCancel) {
    commentCancel.addEventListener("click", function(event) {
        event.preventDefault();
        cancelEdition();
    });
}

function getComments() {
    let article_id = window.location.pathname.split('/')[2];

    fetch(`/getComments/${comment_type}/${article_id}`, {
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
    let editBtn = clone.querySelector(".comment-edition");

    // deletable
    if (comment.editable || inArray(userPerms, ["ROLE_ADMIN", "ROLE_MOD"])) {
        deleteBtn.style.setProperty('display', 'block');
        deleteBtn.addEventListener('click', function() {
            deleteComment(id.id);
        });
    }

    if (comment.editable) {
        editBtn.style.setProperty('display', 'block');
        editBtn.addEventListener('click', function() {
            editComment(id.id);
        });
    }

    if (comment.last_edit != null) {
        let last_edit = comment.last_edit.date.replace(".000000", "");
        clone.querySelector(".comment-edit").innerHTML = `Last edit: ${last_edit}`;
    }
    else {
        clone.querySelector(".comment-edit").innerHTML = '';
    }

    //console.log(commentContainer);
    commentContainer.appendChild(clone);
}

function deleteComment(comment_id) {
    fetch(`/deleteComment/${comment_id}`, {
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

function inArray(needle, haystack) {
    let length = haystack.length;
    for(let i = 0; i < length; i++) {
        if(haystack[i] == needle) return true;
    }
    return false;
}

function bindStatisticsButtons() {
    let votesUp = document.querySelectorAll('.voteup');
    let votesDown = document.querySelectorAll('.votedown');
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

    fetch(`/setCommentVote`, {
        method: "POST",
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
    let ids = [];

    x.forEach(element => {
        let id = element.getAttribute('id');
        
        fetch(`/getUserCommentVote/${id}`, {
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

    let container = document.querySelector("#comments-container");
    let voteColumns = container.querySelectorAll(".vote-column");
    
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

function editComment(id) {
    editbox.value = "";
    editing_id = id;
    document.querySelector("#post_comment_title").innerHTML = "Editing Comment";
    const comments = document.querySelectorAll('.vote-column');

    comments.forEach( comment => {
        if (comment.id == id) {
            editbox.value = comment.parentNode.querySelector(".comment-text").innerHTML;
        }
    });
}

function cancelEdition() {
    editbox.value = "";
    editing_id = -1;
    document.querySelector("#post_comment_title").innerHTML = "Post a Comment";
}

getComments();

