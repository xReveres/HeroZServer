# **HeroZServer**

Projekt prywatnego serwera __HeroZ__.
Serwer był pisany w celach edukacyjnych, do użytku prywatnego. Dzielę się kodem, poniważ porzucam projekt.

### Wymagania:
- Serwer WWW lub VPS/Serwer dedykowany z zainstalowanym serwerem WWW (apache2 i PHP)
- PHP 7 i wyżej
- Baza danych MariaDB v10.0 i wyżej

### Instalacja
- Pobierz lub sklonuj repozytorium
- Umieść pliki na serwerze
- Stwórz bazę danych importując schemat bazy z pliku hzpriv.sql
- Plik konfiguracyjny znajdziesz w katalogu "**server/config.php**"
- Nadać uprawnienia zapisu dla katalogu "**server/cache**" (chmod 777)

### Spis wersji

**v.0.2 (aktualnie)**

Dodano:
- Walki band
- Limit odnowienia energii
- Limit treningów
- Bank energii i punktów treningowych
- Podgląd wysłanych wiadomości
- Wspomagacze drużynowe
- Nagrody za codzienne logowanie
- ~~Kasyno Gamble City~~ (wyłączone z powodu braku grafiki maszyny, aby włączyć kasyno znajdź *slotmachine_event_end* w konfiguracji i wprowadź datę późniejszą)

Poprawki:
- Monet za wygraną walkę, obliczało go tak jakbyśmy walkę przegrali
- Za przegrany pojedynek w misji dostajemy mniej expa i monet
- Dodawane jest 5 oponek gdy odblokujemy kolejną strefę
- Zmieniono formułkę w generatorze expa misji.

Wiecej na [Spis wersji](VERSIONS.md)

### Dokumentacja
...Wkrótce


### Licencja
GNU General Public License v3.0