xquery version "1.0";
declare namespace exist = "http://exist.sourceforge.net/NS/exist"; 
declare namespace request="http://exist-db.org/xquery/request";
declare namespace xmldb="http://exist-db.org/xquery/xmldb";
 
declare option exist:serialize "method=xhtml media-type=text/xml indent=yes";
 
(: Call this like this:
For new records:
http://localhost:8080/exist/rest/db/xquery-examples/save-test/new-update-save.xq?new=true
 
For updates where each record has an id:
http://localhost:8080/exist/rest/db/xquery-examples/save-test/new-update-save.xq?id=123
:)
 
(: replace this with your document, for example use request:get-data() :)
let $my-doc := 
<data>
   <id>123</id>
   <message>Hello World</message>
</data>
 
 
let $id := $my-doc/id
 
let $collection := 'xmldb:exist:///db/xquery-examples/save-test'
 
(: this logs you in; you can also get these variables from your session variables :)
let $login := xmldb:login($collection, 'mylogin', 'my-password')
 
 
(: replace this with a unique file name with a sequence number :)
let $file-name := 'test-save.xml'
 
return
if (not($id))
       then (
       let $store-return-status := xmldb:store($collection, $file-name, $my-doc)
             return
                <message>New Document Created {$store-return-status} at {$collection}/{$file-name}</message>
       )
       else (
           let $remove-return-status := xmldb:remove($collection, $file-name)
           let $store-return-status := xmldb:store($collection, $file-name, $my-doc)
           return
                <message>Document {$id} has been successfully updated</message>)
    }</results>