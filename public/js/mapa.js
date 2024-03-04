(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
({ key: "", v: "weekly" });


(async () => {
    await google.maps.importLibrary("maps");
    const Map = google.maps.Map
    const AdvancedMarkerView = google.maps.Marker;


    let map;

    function initMap() {

        map = new Map(document.getElementById("map"), {
            center: { lat: -25.397, lng: 133.644 },
            zoom: 8,
        });
    }
    initMap();

    async function addMarker(position, icono=null) {
        const marker = new AdvancedMarkerView({
            map: map,
            position: position,
            title: "Uluru",
            label: "asdasd",
            icon: icono,
        });
    }
    addMarker({ lat: -25.344, lng: 131.031 },"https://cdn-icons-png.flaticon.com/16/456/456212.png")
    addMarker({ lat: -25.344, lng: 135.031 })






    class Popup extends google.maps.OverlayView {
        position;
        containerDiv;
        constructor(position, element) {
            super();
            this.position = position;
            element.classList.add("popup-bubble");

            // This zero-height div is positioned at the bottom of the bubble.
            const bubbleAnchor = document.createElement("div");

            bubbleAnchor.classList.add("popup-bubble-anchor");
            bubbleAnchor.appendChild(element);
            // This zero-height div is positioned at the bottom of the tip.
            this.containerDiv = document.createElement("div");
            this.containerDiv.classList.add("popup-container");
            this.containerDiv.appendChild(bubbleAnchor);
            // Optionally stop clicks, etc., from bubbling up to the map.
            Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
        }
        /** Called when the popup is added to the map. */
        onAdd() {
            this.getPanes().floatPane.appendChild(this.containerDiv);
        }
        /** Called when the popup is removed from the map. */
        onRemove() {
            if (this.containerDiv.parentElement) {
                this.containerDiv.parentElement.removeChild(this.containerDiv);
            }
        }
        /** Called each frame when the popup needs to draw itself. */
        draw() {
            const divPosition = this.getProjection().fromLatLngToDivPixel(
                this.position,
            );
            // Hide the popup when it is far out of view.
            const display =
                Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000
                    ? "block"
                    : "none";

            if (display === "block") {
                this.containerDiv.style.left = divPosition.x + "px";
                this.containerDiv.style.top = divPosition.y + "px";
            }

            if (this.containerDiv.style.display !== display) {
                this.containerDiv.style.display = display;
            }
        }
    }

    popup = new Popup(
        new google.maps.LatLng(-25.344,  132.031),
        document.getElementById("content"),
    );
    popup.setMap(map);
}




) ()
//https://developers.google.com/maps/documentation/javascript/examples/overlay-popup
//https://developers.google.com/maps/documentation/javascript/markers?hl=es-419
