import "./bootstrap";

import Alpine from "alpinejs";

// Import animation libraries
import AOS from "aos";
import "aos/dist/aos.css";
// Temporary remove tsParticles initialization
// import { tsParticles } from "@tsparticles/engine";
// import { loadFull } from "tsparticles";

window.Alpine = Alpine;

// Alpine.js countdown component for event start
Alpine.data("countdown", () => ({
    days: 0,
    hours: 0,
    minutes: 0,
    seconds: 0,
    endTime: new Date("April 26, 2025 15:00:00").getTime(),
    init() {
        this.update();
        setInterval(() => this.update(), 1000);
    },
    update() {
        try {
            const now = Date.now();
            const delta = Math.max(0, this.endTime - now);

            if (delta <= 0) {
                this.days = 0;
                this.hours = 0;
                this.minutes = 0;
                this.seconds = 0;
                return;
            }

            this.days = Math.floor(delta / (1000 * 60 * 60 * 24));
            this.hours = Math.floor(
                (delta % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            this.minutes = Math.floor((delta % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((delta % (1000 * 60)) / 1000);
        } catch (error) {
            console.error("Error updating countdown:", error);
            this.days = 0;
            this.hours = 0;
            this.minutes = 0;
            this.seconds = 0;
        }
    },
}));

// Initialize scroll animations
AOS.init({ once: true, duration: 1200 });

// Remove tsParticles initialization for now
// (async () => {
//     try {
//         await loadFull(tsParticles);
//         tsParticles.load("tsparticles", {
//             fpsLimit: 60,
//             interactivity: {
//                 events: {
//                     onHover: { enable: true, mode: "repulse" },
//                     onClick: { enable: true, mode: "push" },
//                 },
//                 modes: { repulse: { distance: 100 }, push: { quantity: 4 } },
//             },
//             particles: {
//                 number: { value: 80, density: { enable: true, area: 800 } },
//                 color: { value: ["#ff0080", "#00ffff", "#39ff14", "#8a2be2"] },
//                 shape: { type: "circle" },
//                 opacity: { value: 0.7 },
//                 size: { value: 3, random: { enable: true, minimumValue: 1 } },
//                 move: {
//                     enable: true,
//                     speed: 2,
//                     outModes: { default: "bounce" },
//                 },
//             },
//         });
//     } catch (error) {
//         console.error("Error loading particles:", error);
//     }
// })();

Alpine.start();
