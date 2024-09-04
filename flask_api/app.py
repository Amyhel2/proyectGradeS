from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/upload', methods=['POST'])
def upload_file():
    if not request.data:
        return jsonify({"error": "No file part"}), 400

    try:
        # Guarda el archivo recibido
        with open('received_image.jpg', 'wb') as f:
            f.write(request.data)
        print("Archivo recibido y guardado.")
        return jsonify({"message": "File received successfully"}), 200
    except Exception as e:
        print("Error al guardar el archivo:", str(e))
        return jsonify({"error": "Failed to save file"}), 500

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000, debug=True)










































