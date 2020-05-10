# Assignment

Implement the Tic-Tac-Toe game <https://en.wikipedia.org/wiki/Tic-tac-toe.>
The game should be a web app which uses a REST API backend.

Build a frontend application that uses the APIs built enabling user to play it with the server.

* REST API. The choice of technology is up to you, as long as it implements RESTfull specification.
No data storage is required, try to keep slim with your implementation.
It is recommended to follow OpenApi specification provided with the Yaml file.
File is using swagger format, for better visualisation of it, following online tool can be used: <https://editor.swagger.io/>

* For the Web App:
Try to make component structure simple so as application itself.
The frontend application should heavily use APIs enabling user to play game with the server.
Style Sheets are not that important, main concern is a proper communication and handling all the possible responses by the server.
Other edge use case scenarios handling would be plus. So think out of the box .

NOTE: WELL STRUCTURING OF THE SOLUTION FOR BOTH REST API AND WEB APPLICATION IS MUST.

## Game flow

* The client (player) starts a game, makes a request to server to initiate a TicTakToe board ( Client (player) will always use cross );
* The backend responds with the location URL of the started game;
* Client gets the board state from the URL;
* Client makes a move, and move is sent back to the server;
* BackEnd validates the move, makes it's own move and updates the game state. The updated game state is returned in the response;
* And so on. The game is over once the computer or the player gets 3 noughts or crosses, horizontally, vertically or diagonally or there are no moves to be made.
