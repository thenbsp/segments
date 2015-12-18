/**
 * GET/POST/PUT/DELETE Request
 * Created by thenbsp (thenbsp@gmail.com)
 * 
 * @param  string   method   request method
 * @param  string   url      request url
 * @param  object   data     request data
 * @param  function callback request callback
 * @param  string   type     data type
 */
$http = function(method, url, data, callback, type) {

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
$http('GET', '/user/1', function(response) {
    console.log(response.info);
});

// create user
$http('POST', '/user', function(response) {
    console.log(response.info);
});

// edit user by id
$http('PUT', '/user/1', function(response) {
    console.log(response.info);
});

// delete user by id
$http('DELETE', '/user/1', function(response) {
    console.log(response.info);
});
