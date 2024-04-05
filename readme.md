# Project: Sql-chat

Voordat de applicatie wordt uitgevoerd, is het noodzakelijk de database te configureren door een basistabelstructuur te creëren. 
De volledige structuur moet worden opgeslagen in het bestand "database.sql". 
Daarnaast moeten de gegevens om verbinding te maken met de database worden ingevuld in het bestand "/php/sql_connect.php".

Vervolgens moet Docker worden gebruikt om de applicatie te draaien.
docker-compose up -d

Om de applicatie te bekijken kunt u ook terecht op de site https://chat.heboba.site waar de nieuwste versie van de applicatie al draait.




Wat is er geïmplementeerd in het project?
- De mogelijkheid om een account aan te maken en in te loggen.
- De mogelijkheid om een chatroom aan te maken en deel te nemen aan een bestaande chatroom.
- De mogelijkheid om berichten te verzenden en te ontvangen in een chatroom.
- Syncronisatie van berichten tussen alle actieve windows.
- De mogelijkheid om een bericht te bewerken en te verwijderen.
- De mogelijkheid om uit te loggen, chatroom te verlaten en invite link te kreeren.

Wat is er nog niet geïmplementeerd in het project?
- Mogelijkheid om aangepaste afbeeldingen in te stellen.
- Files uploaden.
- Mogelijkheid om een chatroom te verwijderen. (Moet worden verwijderd wanneer alle gebruikers de chat verlaten.)
- Vervaldatum van de invite link.
- Mogelijkheid om het wachtwoord, gebruikersnaam te wijzigen.
- Mogelijkheid om de account te verwijderen.
- Gebruiksvriendelijkere interface

