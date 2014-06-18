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