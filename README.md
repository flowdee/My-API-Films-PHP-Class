#My API Films PHP Class
This PHP Class was created in order to communicate with My API Films.
For more information please take a look into the official [My API Films documentation](http://www.myapifilms.com/ "My API Films documentation").

##Installation
In order to use this class respectively the API we suggest using an access **Token** which will be will be mandatory soon. You can easily gent your token [here](http://www.myapifilms.com/form.jsp "here").

``` php
// Including class to your project
require('My-API-Films.php');

// Setup My API Films with your credentials
$api = new My_API_Films();
$api->set_token('MY_API_FILMS_TOKEN_HERE');
```

Please replaced <code>MY_API_FILMS_TOKEN_HERE</code> with your private token.

##Examples
###Receive movie data by id
``` php
// Receive basic movie data
$movie = $api->get_entry_by_id('tt1843866');
var_dump($movie);
```

###Receive movie data by id including additional parameters
``` php
// Prepare parameters
$param = array(
	'trailer' => true, 
	'actors' => 'S'
);		

// Receive enhanced movie data
$movie = $api->get_entry_by_id('tt1843866', $param);
var_dump($movie);
```

###Receive movie trailer url
``` php
// Get movie trailer url
$trailer = $api->get_entry_trailer('tt1843866');
echo($trailer);
```

##What's coming next?
I'm planning to enhance the class continuously in order to receive more specific data. Please take a look into the [issues](https://github.com/flowdee/my-api-films-php-class/issues "issues") and create a new one if you need a special function/enhancement.

##Credits
* [Ticksy](http://www.myapifilms.com/ "My API Films")

If you don't want to miss an update or say hello, follow me on Twitter: [@flowdee](https://twitter.com/flowdee "@flowdee") :wink: