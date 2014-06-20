declare function local:list-options() 
    as element()*{
        <div>
            <label for="roomOptions">Optiuni camera:</label>
            <input name="roomOptions" id="roomOptions" list="listOptions" 
            placeholder="{doc("optionsDb.xml")//optiune[@id=1]/text()}"/>
            <datalist id="listOptions">
            {
               for $option in doc("optionsDb.xml")//optiune
               return
                   <option value="{$option/text()}"/>
            }
            </datalist>
        </div> 
};   
declare function local:display-facilities() 
    as element()*{
    for $categ in doc("facilitiesDb.xml")//categ
      return 
        <fieldset>
              {
                 (<br></br>, <legend>{data($categ/@name)}</legend>),
                  for $facility at $count in $categ/facilitate
                    return 
                      (
                          <label>{$facility/text()}</label>,    
                          <input id="facility" name="facility[]" type="checkbox" value="{$facility/text()}"></input>
                       )
              }   
          </fieldset>
};          
declare function local:insert-property-charact($type as xs:string, $name as xs:string,
        $address as xs:string, $stars-number as xs:decimal, $total-rooms as xs:decimal, 
        $presentation as xs:string, $accommod-rules as xs:string)
    as element()*{
    let $file := "propertiesDb.xml"
    let $new-id := local:last-property-id() + xs:decimal(1)
    return
        update insert 
        <proprietate type="{fn:lower-case($type)}" id="{$new-id}">
            <denumire>{$name}</denumire>
            <adresa>{$address}</adresa>
            <numarStele>{$stars-number}</numarStele>
            <totalCamere>{$total-rooms}</totalCamere>
            <prezentare>{$presentation}</prezentare>
            <reguliCazare>{$accommod-rules}</reguliCazare>
        </proprietate> into doc($file)/proprietati
};
(: functie care insereaza o camera in ultima proprietate adauga in propertiex.xml :)
declare function local:insert-room($property-id as xs:decimal, $type as xs:string, 
        $price as xs:decimal)
    as element()*{
    let $file := "propertiesDb.xml"
    let $new-id := local:last-room-id($property-id) + xs:decimal(1)
    let $room := <camera id="{$new-id}" tip="{$type}" pret="{$price}"/>
    let $property-node := doc($file)/proprietati/proprietate[@id=$property-id]
    return
        if($new-id = xs:decimal(1)) then
            update insert <camere>{$room}</camere> into $property-node
        else
            update insert $room into $property-node/camere
};
declare function local:last-id-from-optionsfile() as xs:decimal
{
    let $file := "optionsDb.xml"  
    let $id := doc($file)//optiune[last()]/data(@id)
    return $id
};
(: apeleaza functia pentru tipul de camera si pretul date ca parametru :)
declare function local:insert-option($room-id as xs:decimal, $option as xs:string)
    as element()*{
    let $file := "propertiesDb.xml"
    let $last-property-id := local:last-property-id()
    let $new-option-id := local:last-option-id($last-property-id, $room-id) + xs:decimal(1)
    let $room-node := doc($file)//proprietate[@id=$last-property-id]//camera[@id=$room-id]
    return 
        if(exists($room-node)) then
            if($new-option-id = xs:decimal(1)) then
                update insert <optiuni><optiune id="{$new-option-id}">{$option}</optiune></optiuni> into $room-node
            else
                update insert <optiune id="{$new-option-id}">{$option}</optiune> into $room-node/optiuni
        else 
            <empty>empty1</empty>
};
(: array-ul din $_POST incepe de la 0, id-urile sunt de la 1 in baza de date xquery, de aceea adunam 1 :)

declare function local:insert-facilities($facility as xs:string)
    as element()*{
    let $file := "propertiesDb.xml"
    let $last-property-id := local:last-property-id()
    let $new-facility-id := local:last-facility-id($last-property-id) + xs:decimal(1)
    let $property-node := doc($file)//proprietate[@id=$last-property-id]
    return
        if($new-facility-id=xs:decimal(1)) then
            update insert <facilitati><facilitate id="{$new-facility-id}">{$facility}</facilitate></facilitati>
            into $property-node
        else
            update insert <facilitate id="{$new-facility-id}">{$facility}</facilitate>
            into $property-node/facilitati
};
 
