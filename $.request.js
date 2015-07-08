/**
 * GET/POST/PUT/DELETE Request
 * @param  string   method   request method
 * @param  string   url      request url
 * @param  object   data     request data
 * @param  function callback request callback
 * @param  string   type     data type
 */
$.request = function(method, url, data, callback, type) {

    var allows = ['GET', 'POST', 'PUT', 'DELETE'];
    var method = ($.inArray(method, allows) === -1) ? allows[0] : method;

    if( $.isFunction(data) ) {
        callback = data;
        data = undefined;
    }

    return $.ajax({
        url: url,
        type: method,
        dataType: (type || 'json'),
        data: data,
        success: callback
    });
}

// get user by id
$.request('GET', '/user/1', function(response) {
    console.log(response.info);
});

// create user
$.request('POST', '/user', function(response) {
    console.log(response.info);
});

// edit user by id
$.request('PUT', '/user/1', function(response) {
    console.log(response.info);
});

// delete user by id
$.request('DELETE', '/user/1', function(response) {
    console.log(response.info);
});