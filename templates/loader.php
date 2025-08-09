<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
            visibility: hidden;
        }

        #page-loader.visible {
            opacity: 1;
            visibility: visible;
        }

        .spinner {
            position: relative;
            width: 8vw;
            height: 8vw;
            perspective: 16vw;
        }

        .spinner div {
            width: 100%;
            height: 100%;
            background: #474bff;
            position: absolute;
            left: 50%;
            transform-origin: left;
            animation: spinner-16s03x 2s infinite;
        }

        .spinner div:nth-child(1) {
            animation-delay: 0.15s;
        }

        .spinner div:nth-child(2) {
            animation-delay: 0.3s;
        }

        .spinner div:nth-child(3) {
            animation-delay: 0.45s;
        }

        .spinner div:nth-child(4) {
            animation-delay: 0.6s;
        }

        .spinner div:nth-child(5) {
            animation-delay: 0.75s;
        }

        @keyframes spinner-16s03x {
            0% {
                transform: rotateY(0deg);
            }

            50%,
            80% {
                transform: rotateY(-180deg);
            }

            90%,
            100% {
                opacity: 0;
                transform: rotateY(-180deg);
            }
        }

        /* Media query for smaller screens */
        @media (max-width: 600px) {
            .spinner {
                width: 16vw;
                height: 16vw;
                perspective: 32vw;
            }
        }

        /* Media query for larger screens */
        @media (min-width: 1200px) {
            .spinner {
                width: 6vw;
                height: 6vw;
                perspective: 12vw;
            }
        }
    </style>
</head>

<body>

    <div id="page-loader">
        <div class="spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div>
            <br><br><br><br><br><br><br><br><br>
            <p style="margin-left: -88px;"><span style="font-size:10px; font-family:monospace; color:deepskyblue">Made by</span> <em><strong style="font-family: monospace; color:white">INFINITI TECH HUB</strong></em> </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('page-loader');
            const startTime = Date.now();
            const loadDuration = 3000; // 3 seconds in milliseconds

            if (loader) {
                loader.classList.add('visible');
                setTimeout(() => {
                    loader.classList.remove('visible');
                }, loadDuration);
            }
        });
    </script>
</body>

</html>