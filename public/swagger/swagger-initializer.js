window.onload = function() {
    window.ui = SwaggerUIBundle({
        url: "/storage/swagger/swagger.json",
        dom_id: '#swagger-ui',
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout"
    });
};
