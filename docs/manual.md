<p align="center">
    <h1 align="center">Mailbox API (Manual)</h1>
    <br>
</p>

API endpoint
------------

API method could be accessible from endpoint `http://your-domain.local/messages/[method]`
where `[method]` is API method.

All examples in this documentation will use endpoint `http://mail.local/message`

Authentication
--------------

For authentication used two ways to send an access token:
 * Query parameter: the access token is sent as a query parameter in the API URL, e.g.,
~~~
http://mail.local/message/list?access-token=xxxxxxxx.
~~~
 * HTTP header: the access token could be passed in as a "X-MailBox-access-token" HTTP header

User data has been seeded during the migration you can find `access-token` each user in field `user.access-token` in your database.

Actually each user that was created during migration, had got access-token according to next template `accessToken[uid]` where `[uid]` this is field `[uid]` from file `messages_sample.json`

Content Type
------------

Set content type to `application/xml` and you will see the result is returned in XML format.
Set content type to `application/json` and you will see the result is returned in JSON format.

Test by CURL
------------

You may access your APIs with the curl command like the following,

```bash
$ curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/list"

HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 08:53:44 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
X-Pagination-Total-Count: 4
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 10
Link: <http://mail.local/message/list?page=1&per-page=10>; rel=self
Content-Length: 464
Content-Type: application/json; charset=UTF-8

[{"id":1,"sender":"Ernest Hemingway","subject":"animals","timeSent":1459239867,"wasRead":true,"wasArchived":false},{"id":4,"sender":"George Orwell","subject":"chemist","timeSent":1456744407,"wasRead":false,"wasArchived":false},{"id":5,"sender":"James Joyce","subject":"nuclear engineer","timeSent":1456733427,"wasRead":false,"wasArchived":false},{"id":6,"sender":"Jane Austen","subject":"treasure-hunter","timeSent":1456730427,"wasRead":false,"wasArchived":false}]
```


LIST
-------------

~~~
http://mail.local/message/list
~~~

Retrieve a paginateable list of messages in mailbox.

Could be used parameter `type` with following value:
 * `all` return all messages
 * `archived` return only archived messages
 * `active` return not archived messages (by default)

For pagination used parameter `page=[page-number]`.
Pagination data contains in HTTP headers:
~~~
X-Pagination-Total-Count: 4
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 10
~~~


Examles:

Get list all messages, page 2
```bash
$curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/list?type=all&page=2"

HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 09:15:20 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
X-Pagination-Total-Count: 6
X-Pagination-Page-Count: 2
X-Pagination-Current-Page: 2
X-Pagination-Per-Page: 3
Link: <http://mail.local/message/list?type=all&page=2&per-page=3>; rel=self, <http://mail.local/message/list?type=all&page=1&per-page=3>; rel=first, <http://mail.local/message/list?type=all&page=1&per-page=3>; rel=prev
Content-Length: 350
Content-Type: application/json; charset=UTF-8

[{"id":4,"sender":"George Orwell","subject":"chemist","timeSent":1456744407,"wasRead":false,"wasArchived":false},{"id":5,"sender":"James Joyce","subject":"nuclear engineer","timeSent":1456733427,"wasRead":false,"wasArchived":false},{"id":6,"sender":"Jane Austen","subject":"treasure-hunter","timeSent":1456730427,"wasRead":false,"wasArchived":false}]
```

Get list archived messages
```bash
curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/list?type=archived"
HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 09:16:50 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
X-Pagination-Total-Count: 2
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 3
Link: <http://mail.local/message/list?type=archived&page=1&per-page=3>; rel=self
Content-Length: 219
Content-Type: application/json; charset=UTF-8

[{"id":2,"sender":"Stephen King","subject":"adoration","timeSent":1459248747,"wasRead":true,"wasArchived":true},{"id":3,"sender":"Virgina Woolf","subject":"debt","timeSent":1456767867,"wasRead":true,"wasArchived":true}]
```

Get active messages second page and set row per page setting (it is 20 by default)
```bash
$curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/list?type=active&page=2&per-page=3"

HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 09:23:43 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
X-Pagination-Total-Count: 4
X-Pagination-Page-Count: 2
X-Pagination-Current-Page: 2
X-Pagination-Per-Page: 3
Link: <http://mail.local/message/list?type=active&page=2&per-page=3>; rel=self, <http://mail.local/message/list?type=active&page=1&per-page=3>; rel=first, <http://mail.local/message/list?type=active&page=1&per-page=3>; rel=prev
Content-Length: 119
Content-Type: application/json; charset=UTF-8

[{"id":6,"sender":"Jane Austen","subject":"treasure-hunter","timeSent":1456730427,"wasRead":false,"wasArchived":false}]
```


SHOW
----

~~~
http://mail.local/message/show?id=[message_id]
~~~
Retrieve message by id (you can get it from method `list`).

Example:
```bash
curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/show?id=3"
HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 09:31:15 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
Content-Length: 292
Content-Type: application/json; charset=UTF-8

{"id":3,"sender":"Virgina Woolf","subject":"debt","message":"The story is about an obedient midwife and a graceful scuba diver who is in debt to a fence. It takes place in a magical part of our universe. The story ends with a funeral.","timeSent":1456767867,"wasRead":true,"wasArchived":true}
```

If id not found you get an exception :
```bash
$curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/show?id=1000"

HTTP/1.1 404 Not Found
Date: Tue, 07 Nov 2017 09:36:35 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
Content-Length: 142
Content-Type: application/json; charset=UTF-8

{"name":"Not Found","message":"Message id: 1000 was not found in this mailbox","code":0,"status":404,"type":"yii\\web\\NotFoundHttpException"}
```


READ
----

~~~
http://mail.local/message/read?id=[message_id]
~~~

This action “reads” a message and marks it as read in database.

Example:
```bash
$curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/read?id=5"

HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 09:41:18 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
Content-Length: 272
Content-Type: application/json; charset=UTF-8

{"id":5,"sender":"James Joyce","subject":"nuclear engineer","message":"The story is about an ugly nuclear engineer. It starts in a manufacturing city in Africa. The future of warfare is a major part of this story.","timeSent":1456733427,"wasRead":true,"wasArchived":false}
```


TO-ARCHIVE
----------

~~~
http://mail.local/message/to-archive?id=[message_id]
~~~
This action sets a message to archived and return a message.

```bash
curl -i -H "Content-Type: application/json" -H "X-MailBox-access-token: accessToken25" "http://mail.local/message/to-archive?id=5"
HTTP/1.1 200 OK
Date: Tue, 07 Nov 2017 09:43:40 GMT
Server: Apache/2.4.23 (Win32) PHP/5.6.28
X-Powered-By: PHP/5.6.28
Content-Length: 271
Content-Type: application/json; charset=UTF-8

{"id":5,"sender":"James Joyce","subject":"nuclear engineer","message":"The story is about an ugly nuclear engineer. It starts in a manufacturing city in Africa. The future of warfare is a major part of this story.","timeSent":1456733427,"wasRead":true,"wasArchived":true}
```
