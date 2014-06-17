(: fisier ce contine functiile xquery folosite la inregistrarea/logarea 
    unui utilizator :)

(: functie ce verifica existenta unei adrese de email in baza de date :)
declare function local:check-email-existence($entered-email as xs:string)
    as xs:decimal{
        let $users-file := "users.xml"
        (: preluam nodul ce contine emailul :)
        let $email := doc($users-file)//user/email
        return 
            (: daca valoarea nodului este egala cu emailul introdus :)
            if($email/text()=$entered-email) then
                (: returneaza 1 :)
                xs:decimal(1)
            else
                (: altfel, returneaza 0:)
                xs:decimal(0)
};
(: functie ce insereaza datele unui nou utilizator inregistrat :)
declare function local:insert-user-info($email, $password, $firstname, $lastname)
    as element()*{
        let $users-file := "users.xml"
        (: preluam id-ul ultimului utilizator inregistrat :)
        (: functia local:last-user-id se gaseste in general.php din folderul curent :)
        let $new-user-id := local:last-user-id() + xs:decimal(1)
        return 
            update insert 
                (: se insereaza urmatoarea secventa de noduri:)
                <user id="{$new-user-id}">
                    <email>{$email}</email>
                    <password>{$password}</password>
                    <firstname>{$firstname}</firstname>
                    <lastname>{$lastname}</lastname>
                </user>
                (: in fisierul users.xml :)
            into doc($users-file)/users
};
(: functie care verifica daca o anumita combinatie de email si parola exista in baza de date :)
declare function local:check-credentials($email as xs:string, $password as xs:string)
    as element()*{
        let $users-file := "users.xml"
        return
            (: se returneaza un xml care va contine cate un nod entry pentru fiecare combinatie de 
            acest tip gasit; in mod normal, doar una poate sa existe :)
            <entries>
                {
                (: pentru fiecare utilizator din fisier :)
                for $user in doc($users-file)/users/user
                (: daca emailul si parola coincid cu cele date ca parametri :)
                where $user/email/text()=$email and $user/password/text()=$password
                    (: se creaza o noua intrare ce contine 1:)
                    return <entry>{xs:decimal(1)}</entry>
                }
            </entries>
            (: altfel se va returna un nod de tip entries gol :)
};
(: functie care verifica daca exista noduri de tip entry in urma apelului functiei de mai sus :)
declare function local:credentials-exist($email as xs:string, $password as xs:string)
    as xs:decimal{
        let $users-file := "users.xml"
        let $results := local:check-credentials($email, $password)
        return
            (: daca exista nod de tip entry :)
            if(exists($results//entry)) then
                (: se returneaza 1, utilizatorul este inregistrat in baza de date :)
                xs:decimal(1)
            else 
                (: altfel, se returneaza 0 :)
                xs:decimal(0)
};