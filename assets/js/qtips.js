jQuery(document).ready(function() {

    jQuery('#bg-color').qtip({
        content:'This is the background of the locked section (box). It will be displayed when content is locked. The best advice would be to use some attention grabbing color that stands out from your website design.',
        position: {
            corner: {
                tooltip: 'leftMiddle', // Use the corner...
                target: 'rightMiddle' // ...and opposite corner
            },
            adjust: {
                x: 25,
                y: 0
            }
        },
        show: {when: {event: 'mouseover'},
            ready: false},
        hide: {
            when: {
                target: jQuery(document.body).children().not( jQuery(self) ),
                event: 'mouseout'
            }
        },
        style: {
            border: {
                width: 5,
                radius: 5
            },
            padding: 5,
            width: 266,
            textAlign: 'left',
            tip: true, // Give it a speech bubble tip with automatic corner detection
            name: 'dark' // Style it according to the preset 'cream' style
        }
    });

jQuery('#title').qtip({
    content:'This is your \'Call To Action\'. Give your visitors a good reason why they should LIKE your page - give something they get excited about or something controversial that makes people curious.',
    position: {
        corner: {
            tooltip: 'leftMiddle', // Use the corner...
            target: 'rightMiddle' // ...and opposite corner
        }
    },
    show: {when: {event: 'mouseover'},
        ready: false},
    hide: {
        when: {
            target: jQuery(document.body).children().not( jQuery(self) ),
            event: 'mouseout'
        }
    },
    style: {
        border: {
            width: 5,
            radius: 5
        },
        padding: 5,
        width: 266,
        textAlign: 'left',
        tip: true, // Give it a speech bubble tip with automatic corner detection
        name: 'dark' // Style it according to the preset 'cream' style
    }
});

jQuery('#title-clr').qtip({
    content:'It will be displayed inside the box, so make sure it stands out on the background color you selected.',
    position: {
        corner: {
            tooltip: 'leftMiddle', // Use the corner...
            target: 'rightMiddle' // ...and opposite corner
        },
        adjust: {
            x: 25,
            y: 0
        }
    },
    show: {when: {event: 'mouseover'},
        ready: false},
    hide: {
        when: {
            target: jQuery(document.body).children().not( jQuery(self) ),
            event: 'mouseout'
        }
    },
    style: {
        border: {
            width: 5,
            radius: 5
        },
        padding: 5,
        width: 266,
        textAlign: 'left',
        tip: true, // Give it a speech bubble tip with automatic corner detection
        name: 'dark' // Style it according to the preset 'cream' style
    }
});

jQuery('#title-font').qtip({
    content:'My favorite is Comic Sans MS, but you can select any of those. With CS MS I think you will create more interruption to a regular visitor eye pattern.',
    position: {
        corner: {
            tooltip: 'leftMiddle', // Use the corner...
            target: 'rightMiddle' // ...and opposite corner
        }
    },
    show: {when: {event: 'mouseover'},
        ready: false},
    hide: {
        when: {
            target: jQuery(document.body).children().not( jQuery(self) ),
            event: 'mouseout'
        }
    },
    style: {
        border: {
            width: 5,
            radius: 5
        },
        padding: 5,
        width: 266,
        textAlign: 'left',
        tip: true, // Give it a speech bubble tip with automatic corner detection
        name: 'dark' // Style it according to the preset 'cream' style
    }
});

jQuery('#buttons-align').qtip({
    content:'I like to align everything left, it looks more professional, but you can center or even put on the right as well.',
    position: {
        corner: {
            tooltip: 'leftMiddle', // Use the corner...
            target: 'rightMiddle' // ...and opposite corner
        }
    },
    show: {when: {event: 'mouseover'},
        ready: false},
    hide: {
        when: {
            target: jQuery(document.body).children().not( jQuery(self) ),
            event: 'mouseout'
        }
    },
    style: {
        border: {
            width: 5,
            radius: 5
        },
        padding: 5,
        width: 266,
        textAlign: 'left',
        tip: true, // Give it a speech bubble tip with automatic corner detection
        name: 'dark' // Style it according to the preset 'cream' style
    }
});

jQuery('#exp-date').qtip({
    content:'This is the time during which a visitor who already liked your page will not need to like it again in order to see the content. By default we set 3 days, but you can select a different period.',
    position: {
        corner: {
            tooltip: 'leftMiddle', // Use the corner...
            target: 'rightMiddle' // ...and opposite corner
        },
        adjust: {
            x: 25,
            y: 0
        }
    },
    show: {when: {event: 'mouseover'},
        ready: false},
    hide: {
        when: {
            target: jQuery(document.body).children().not( jQuery(self) ),
            event: 'mouseout'
        }
    },
    style: {
        border: {
            width: 5,
            radius: 5
        },
        padding: 5,
        width: 266,
        textAlign: 'left',
        tip: true, // Give it a speech bubble tip with automatic corner detection
        name: 'dark' // Style it according to the preset 'cream' style
    }
});

});

