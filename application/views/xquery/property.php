declare function local:list-options() 
    as element()*{
        <div>
            <label for="options">Optiuni camera:</label>
            <input name="options" id="options" list="listOptions" 
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