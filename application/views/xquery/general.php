declare function local:last-property-id()
    as xs:decimal{
    let $file := "propertiesDb.xml"
    return 
        if(exists(doc($file)//proprietate)) then 
	        (doc($file)//proprietate)[last()]/data(@id)
 	    else 
     	    xs:decimal(0)
};

declare function local:last-room-id($property-id)
    as xs:decimal{
    let $file := "propertiesDb.xml"
    let $property-node := doc($file)//proprietate[@id=$property-id]
    return 
        if(exists($property-node)) then
            if(exists($property-node/camere/camera)) then
                ($property-node/camere/camera)[last()]/data(@id)
            else
                xs:decimal(0)
        else
            xs:decimal(-1)
};

declare function local:last-option-id($property-id, $room-id)
    as xs:decimal{
        let $file := "propertiesDb.xml"
        let $property-node := doc($file)//proprietate[@id=$property-id]
        let $room-node := $property-node/camere/camera[@id=$room-id]
        return 
            if(exists($property-node)) then
                if(exists($room-node)) then
                    if(exists($room-node/optiuni/optiune)) then
                        ($room-node//optiune)[last()]/data(@id)
                    else
                        xs:decimal(0)
                else
                    xs:decimal(-1)
            else 
                xs:decimal(-2)
};

declare function local:get-property-path($property-id as xs:decimal)
    as element()*{
        let $file := 'propertiesDb.xml'
        return
            if(exists(doc($file)//proprietati/proprietate[@id=$property-id])) then
                doc($file)//proprietati/proprietate[@id=$property-id]
            else
                <empty>empty-path</empty>
};

declare function local:last-user-id()
    as xs:decimal{
    let $users-file := "users.xml"
    return 
        if(exists(doc($users-file)//user)) then 
            doc($users-file)//user[last()]/data(@id)
        else
            xs:decimal(0)
};

declare function local:last-facility-id($property-id)
    as xs:decimal*{
        let $file := "propertiesDb.xml"
        let $facility-node := (doc($file)//proprietate[@id=$property-id])/facilitati/facilitate
        return 
            if(exists($facility-node)) then
                ($facility-node[last()])/data(@id)
            else
                xs:decimal(0)
};
