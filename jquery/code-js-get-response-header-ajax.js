$.ajax({
  url: root + '/posts/1',
  headers: {'test': 'test'},
  method: 'GET'
}).then(function(data, status, xhr) {
  console.log(xhr.getAllResponseHeaders());
});