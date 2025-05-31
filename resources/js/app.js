import "./bootstrap";

import Alpine from "alpinejs";

// Import animation libraries
import AOS from "aos";
import "aos/dist/aos.css";
// Temporary remove tsParticles initialization
// import { tsParticles } from "@tsparticles/engine";
// import { loadFull } from "tsparticles";

window.Alpine = Alpine;

// Initialize Alpine.js before everything else
document.addEventListener("DOMContentLoaded", () => {
    // Start Alpine immediately at the beginning
    Alpine.start();

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
});
