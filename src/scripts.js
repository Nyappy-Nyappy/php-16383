document.getElementById('issue-form').addEventListener('submit', function (e) {
    var title = document.getElementById('title').value;
    var issueCommit = document.getElementById('issue_commit').value;
    var priority = document.getElementById('priority').value;

    if (title === '' || issueCommit === '' || priority === '') {
        e.preventDefault();
        document.getElementById('error-message').textContent = 'すべてのフィールドを入力してください。';
    }
});
