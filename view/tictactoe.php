<?php
$title = 'Home Page';
ob_start();
include 'config.php';
include(__DIR__.'/../controller/validate_token.php');
?>
<style>
/* *{outline: red solid 1px} */
:root {
    --blur: 4.76px;
    --spread: -3.4px;
    --horiz: -2.642296268953701px;
    --vert: 2.139689329569448px;
    --game-size: calc(100vw / 9);
    --board-size: 400px;
    --font-size: 5em;

    --bubble-color: blue;
}

@media (max-width: 768px) {
    :root {
        --game-size: calc(100vw / 8);
        --board-size: 100px;
        --font-size: 2em;
        /* Adjust the divisor for smaller screens */
    }
}

@media (max-width: 480px) {
    :root {
        --game-size: calc(100vw / 8);
        --board-size: 100px;
        --font-size: 2em;
        /* Adjust the divisor for very small screens */
    }
}

.board {
    display: grid;
    grid-template-columns: repeat(3, var(--board-size));
    grid-gap: 5px;
    justify-content: center;
    z-index: 100;
}

.cell {
    width: var(--board-size);
    height: var(--game-size);
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: var(--font-size);
    cursor: pointer;
    z-index: 100;

    font-family: "Comic Sans MS", cursive, sans-serif;
    font-weight: 700;
}


.cell:hover {
    background-color: #e0e0e0;
}

.player-x {
    color: red;
}

.player-o {
    color: blue;
}

.winning-cell {
    background-color: #00FF00;
}

button {
    padding: 10px 20px;
    font-size: 1em;
    cursor: pointer;
}

.text-title {
    font-family: Arial, Helvetica, sans-serif;
    letter-spacing: 2px;
    word-spacing: 2px;
    color: white;
    font-weight: 700;
    text-decoration: none solid rgb(68, 68, 68);
    font-style: normal;
    font-variant: normal;
    text-transform: uppercase;
}

.bubbly-button {
    position: relative;
    transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
}

.bubbly-button:focus {
    outline: 0;
}

.bubbly-button:before,
.bubbly-button:after {
    position: absolute;
    content: '';
    display: block;
    width: 140%;
    height: 100%;
    left: -20%;
    z-index: -1000;
    transition: all ease-in-out 0.5s;
    background-repeat: no-repeat;
}

.bubbly-button:before {
    display: none;
    top: -75%;
    background-image: radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, transparent 20%, var(--bubble-color) 20%, transparent 30%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, transparent 10%, var(--bubble-color) 15%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%);
    background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;
}

.bubbly-button:after {
    display: none;
    bottom: -75%;
    background-image: radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, transparent 10%, var(--bubble-color) 15%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%), radial-gradient(circle, var(--bubble-color) 20%, transparent 20%);
    background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;
}

.bubbly-button:active {
    transform: scale(0.9);
    background-color: var(--bubble-color);
    box-shadow: 0 2px 25px rgba(255, 0, 130, 0.2);
}

.bubbly-button.animate:before {
    display: block;
    animation: topBubbles ease-in-out 0.75s forwards;
}

.bubbly-button.animate:after {
    display: block;
    animation: bottomBubbles ease-in-out 0.75s forwards;
}

@keyframes topBubbles {
    0% {
        background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;
    }

    50% {
        background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;
    }

    100% {
        background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;
        background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
    }
}

@keyframes bottomBubbles {
    0% {
        background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;
    }

    50% {
        background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;
    }

    100% {
        background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;
        background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
    }
}
</style>
<div class="row">
    <div class="col-12 text-center p-5 mb-5 bg-dark">
        <h1 class="mb-2 text-title">Tic Tac Toe</h1>
        <div class="">
            <div class="board">
                <div class="cell bubbly-button" data-index="0"></div>
                <div class="cell bubbly-button" data-index="1"></div>
                <div class="cell bubbly-button" data-index="2"></div>
                <div class="cell bubbly-button" data-index="3"></div>
                <div class="cell bubbly-button" data-index="4"></div>
                <div class="cell bubbly-button" data-index="5"></div>
                <div class="cell bubbly-button" data-index="6"></div>
                <div class="cell bubbly-button" data-index="7"></div>
                <div class="cell bubbly-button" data-index="8"></div>
            </div>
        </div>
        <button class="btn btn-success my-2" id="restart">Restart Game</button>
    </div>
</div>

<!-- Player Turn Modal -->
<div class="modal fade" id="playerTurnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-5">
            <div class="modal-body text-center">
                <h2 id="playerTurnMessage" class="font-weight: 600;"></h2>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    var animateButton = function(e) {
        e.preventDefault();
        var $target = $(e.target);
        $target.removeClass('animate');
        $target.addClass('animate');
        $target.css('z-index', '999');
        setTimeout(function() {
            $target.removeClass('animate');
            $target.removeClass('bubbly-button');
            $target.css('z-index', '');
        }, 700);
    };

    var bubblyButtons = $(".bubbly-button");
    bubblyButtons.on('click', animateButton);

    let board = ["", "", "", "", "", "", "", "", ""];
    let currentPlayer = "X";
    let gameActive = true;

    function handleCellPlayed(clickedCell, clickedCellIndex) {
        board[clickedCellIndex] = currentPlayer;

        $(clickedCell).removeClass('player-x player-o');

        if (currentPlayer === "X") {
            $(clickedCell).addClass('player-x');
        } else if (currentPlayer === "O") {
            $(clickedCell).addClass('player-o');
        }
        $(clickedCell).text(currentPlayer);
    }

    function handlePlayerChange() {
        currentPlayer = currentPlayer === "X" ? "O" : "X";

        document.getElementById('playerTurnMessage').textContent = currentPlayer + " : Player Turn!";
        var myModal = new bootstrap.Modal(document.getElementById('playerTurnModal'), {
            backdrop: 'static',
            keyboard: false
        });
        myModal.textContent = currentPlayer + " : Player Turn!";
        myModal.show();

        setTimeout(function() {
            myModal.hide();
        }, 1500);
    }

    function checkWinner() {
        const winningCombinations = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8],
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8],
            [0, 4, 8],
            [2, 4, 6]
        ];

        for (let i = 0; i < winningCombinations.length; i++) {
            const [a, b, c] = winningCombinations[i];
            if (board[a] && board[a] === board[b] && board[a] === board[c]) {
                document.querySelector(`[data-index="${a}"]`).classList.add('winning-cell');
                document.querySelector(`[data-index="${b}"]`).classList.add('winning-cell');
                document.querySelector(`[data-index="${c}"]`).classList.add('winning-cell');
                return true;
            }
        }
        return false;
    }

    function handleResultValidation() {

        var modalFooter =
            '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button type="button" class="btn btn-success" id="restartButton">Restart Game</button></div>';

        var modaltimer =
            '<div class="modaltimer text-center my-auto pt-3"><h4 class="text-center w-100 " id="countdownTimer"></h4></div>';

        var myModal = new bootstrap.Modal(document.getElementById('playerTurnModal'), {
            backdrop: 'static',
            keyboard: false
        });

        if (checkWinner()) {
            var text = `Player ${currentPlayer} has won!`;

            $('.modal-body').after(modaltimer);
            document.getElementById('playerTurnMessage').textContent = text;

            myModal.show();

            let countdown = 10; // Countdown from 5 seconds
            let countdownTimer = setInterval(function() {
                document.getElementById('countdownTimer').textContent =
                    `Restarting in ${countdown} seconds...`;
                countdown--;
                if (countdown < 0) {
                    clearInterval(countdownTimer);
                    myModal.hide();
                    handleRestartGame();
                }
            }, 1000);

            $(document).on('click', '#restartButton', function() {
                clearInterval(countdownTimer); // Stop the countdown
                myModal.hide();
                handleRestartGame();
            });

            gameActive = false;
            return;
        }

        if (!board.includes("")) {

            var text = "It's a draw!";

            $('.modal-body').after(modaltimer);
            document.getElementById('playerTurnMessage').textContent = text;

            myModal.show();

            let countdown = 10; // Countdown from 5 seconds
            let countdownTimer = setInterval(function() {
                document.getElementById('countdownTimer').textContent =
                    `Restarting in ${countdown} seconds...`;
                countdown--;
                if (countdown < 0) {
                    clearInterval(countdownTimer);
                    myModal.hide();
                    handleRestartGame();
                }
            }, 1000);

            $(document).on('click', '#restartButton', function() {
                clearInterval(countdownTimer); // Stop the countdown
                myModal.hide();
                handleRestartGame();
            });

            gameActive = false;
        }
    }

    function handleCellClick(event) {
        const clickedCell = event.target;
        const clickedCellIndex = parseInt($(clickedCell).attr('data-index'));

        if (board[clickedCellIndex] !== "" || !gameActive) {
            return;
        }

        handleCellPlayed(clickedCell, clickedCellIndex);
        handleResultValidation();
        if (gameActive) {
            handlePlayerChange();
        }
    }

    function handleRestartGame() {
        board = ["", "", "", "", "", "", "", "", ""];
        gameActive = true;
        currentPlayer = "X";
        $('.cell').text("");
        $('.cell').text("").addClass('bubbly-button').removeClass('winning-cell');
        $('.modaltimer').remove();
    }

    $('.cell').on('click', handleCellClick);
    $('#restart').on('click', handleRestartGame);
});
</script>

<?php
$content = ob_get_clean();
include(__DIR__.'/../template/default.php');
?>