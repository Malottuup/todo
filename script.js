document.getElementById('taskForm').addEventListener('submit', function(e) {
e.preventDefault();
const input = document.getElementById('taskInput');
fetch('tasks.php', {
method: 'POST',
headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
body: 'task=' + encodeURIComponent(input.value)
})
.then(r => r.json())
.then(data => {
const li = document.createElement('li');
li.dataset.id = data.id;
li.innerHTML = '<input type="checkbox" class="toggle"><span>' + data.task + '</span><button class="delete">✕</button>';
document.getElementById('taskList').prepend(li);
input.value = '';
});
});
document.getElementById('taskList').addEventListener('click', function(e) {
const li = e.target.closest('li');
if (e.target.classList.contains('delete')) {
fetch('tasks.php', { method: 'DELETE', body: 'id=' + li.dataset.id })
.then(() => li.remove());
}
if (e.target.classList.contains('toggle')) {
const status = e.target.checked ? 1 : 0;
fetch('tasks.php', { method: 'PUT', body: 'id=' + li.dataset.id + '&is_completed=' + status });
li.classList.toggle('done', status === 1);
}
});