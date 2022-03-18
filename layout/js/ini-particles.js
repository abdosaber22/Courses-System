particlesJS("particles-js", {
  
  "particles": {
    "number": {
      "value": 250,
      "density": {
        "enable": true,
        "value_area": 1500
      }
    },
    "color": {
      "value": "#fff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 1,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.6,
        "sync": false
      }
    },
    "size": {
      "value": 2.5,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 100,
      "color": "#ffffff",
      "opacity": 0.6,
      "width": 1.2
    },
    "move": {
      "enable": true,
      "speed": 8,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "bounce",
      "bounce": true,
      "attract": {
        "enable": true,
        "rotateX": 3600,
        "rotateY": 3600
      }
    }
  },
  
  
  
  "interactivity": {
    "detect_on": "canvas",
    
    "events": {
      "onhover": {
        "enable": true,
        "mode": "grab"
      },
      
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    
    "modes": {
      "grab": {
        "distance": 140,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 100,
        "size": 40,
        "duration": 2,
        "opacity": 1,
        "speed": 3
      },
      
      "repulse": {
        "distance": 200,
        "duration": 0.5
      },
      
      "push": {
        "particles_nb": 5
      },
      
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});
