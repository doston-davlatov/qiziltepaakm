document.getElementById('search-input').addEventListener('input', function(e) {
    const query = e.target.value;
    fetch(`pages/catalog.php?search=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.grid').innerHTML = data;
        });
});