
const editbox = document.querySelector('.comment-editbox');

editbox.addEventListener("keyup", function (event) {
    const len = this.value.length;
    const maxlen = this.getAttribute('maxlength');
    const rem = maxlen - len;

    document.querySelector(".char-remains").innerHTML = "Up to " + maxlen + " characters. " + rem + " characters remaining.";
})