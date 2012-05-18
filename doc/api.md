Configuring the API
===================

Through the UI, select 'Configure Cloud API' you will be asked for the following parameters:

* 'Cloud API URL' - The URL to query the API, normally ends in /api for abiquo
* 'Username' - The username to authenticate as (login will be sent in HTTP or HTTPS, whichever you specify in the URL)
* 'Password' - The login password to the API
* 'API Type' - The type of API to instantiate. Only 'abiquo' exists at this moment however further implementations of the Connector interface can be added

On selecting save, the UI will configure the API class and run a 'test' function to check the credentials and URL.

If this fails, it will respond with the error but still save the details. If this is successful, the successful response will be displayed onscreen.