import os
import numpy as np
import tensorflow as tf
from flask import Flask, request, jsonify
from flask_cors import CORS
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Dropout, Flatten
from tensorflow.keras.preprocessing import image
from PIL import Image
import io

app = Flask(__name__)
CORS(app)

# --- MODEL RECONSTRUCTION ---
# This bypasses version mismatch errors by manually defining the layers
def build_and_load_model(model_path):
    img_shape = (299, 299, 3)
    
    # 1. Recreate base exactly as per your BioFusion notebook
    base_model = tf.keras.applications.Xception(
        include_top=False,
        weights=None, 
        input_shape=img_shape,
        pooling='max'
    )

    # 2. Recreate Sequential architecture
    model = Sequential([
        base_model,
        Flatten(),
        Dropout(0.3),
        Dense(128, activation='relu'),
        Dropout(0.25),
        Dense(4, activation='softmax')
    ])

    # 3. Load only weights
    if os.path.exists(model_path):
        model.load_weights(model_path)
        print(f"Successfully loaded weights from {model_path}")
    else:
        print(f"ERROR: Model file {model_path} not found!")
        
    return model

# Initialize the model (Ensure this file is in the same directory)
MODEL_PATH = '../model/deadlock_model.keras' 
model = build_and_load_model(MODEL_PATH)
labels = ['Glioma', 'Meningioma', 'No Tumor', 'Pituitary Tumor']

def preprocess_image(img_bytes):
    img = Image.open(io.BytesIO(img_bytes))
    if img.mode != "RGB":
        img = img.convert("RGB")
    img = img.resize((299, 299))
    img_array = np.array(img) / 255.0  # Rescale 1/255
    img_array = np.expand_dims(img_array, axis=0)
    return img_array

@app.route('/brain_predict', methods=['POST'])
def predict_image():
    try:
        if 'file' not in request.files:
            return jsonify({'error': 'No file uploaded'}), 400
        
        file = request.files['file']
        img_bytes = file.read()
        processed_img = preprocess_image(img_bytes)

        prediction = model.predict(processed_img)
        class_idx = int(np.argmax(prediction[0]))
        confidence = float(np.max(prediction[0]))

        return jsonify({
            'prediction': labels[class_idx],
            'confidence': f"{confidence * 100:.2f}%",
            'all_probs': {labels[i]: float(prediction[0][i]) for i in range(len(labels))}
        })
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    # Running on 10003 as required by your PHP bridge
    app.run(host='0.0.0.0', port=10003, debug=True)