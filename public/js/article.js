
const editbox = document.querySelector('.comment-editbox');
const commentSubmit = document.querySelector(".button.comment-button");    
const userId = document.querySelector("#userid").innerHTML;
const userPerms = document.querySelector("#userroles").innerHTML;
const commentContainer = document.querySelector('#comments-container table');
console.log('');

editbox.addEventListener("keyup", function (event) {
    const len = this.value.length;
    const maxlen = this.getAttribute('maxlength');
    const rem = maxlen - len;

    document.querySelector(".char-remains").innerHTML = "Up to " + maxlen + " characters. " + rem + " characters remaining.";
})

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
                response.score = 0;
                response.comment = editbox.value;
                response.editable = 1
                createComment(response);
                updateStatisticsButtons();
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
        console.log(response);
        return response.json();
    }).then((response) => {
        response = JSON.parse(response);
        loadComments(response);
    })
    .catch(err => console.log(err));
}

function loadComments(comments) {

    comments.forEach(comment => {
        console.log(comment );
        createComment(comment);
    });
    // updateStatisticsButtons();
    // updateCommentUserResponse();
}

function createComment(comment) {
    const template = document.querySelector("#comment-template");

    const clone = template.content.cloneNode(true);

    const score = clone.querySelector(".score");
    score.innerHTML = comment.score ? comment.score : 0;

    const id = clone.querySelector("#comment_id");
    id.id = comment.comment_id;

    clone.querySelector(".comment-header").innerHTML = 'By <a href="#"><span class="user">' + comment.author + '</span> <a> on ' + comment.date.date;
    clone.querySelector(".comment-text").innerHTML = comment.content;

    let deleteBtn = clone.querySelector(".comment-delete");
    if (comment.editable || inArray(userroles, ["ROLE_ADMIN", "ROLE_MOD"])) {
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

getArticleComments();