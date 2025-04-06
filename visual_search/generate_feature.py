import os
from pathlib import Path
from feature_extractor import FeatureExtractor
from PIL import Image
import numpy as np

if __name__ == '__main__':
    # Create directories if they don't exist
    for dir_path in ['static/img', 'static/feature', 'static/uploaded']:
        os.makedirs(dir_path, exist_ok=True)

    fe = FeatureExtractor()

    # Copy product images to static/img
    source_dir = '../admin_area/product_images'
    if os.path.exists(source_dir):
        for img_path in Path(source_dir).glob("*.jpg"):
            dest_path = f"static/img/{img_path.name}"
            if not os.path.exists(dest_path):
                Image.open(img_path).save(dest_path)

    # Generate feature vectors for all images in static/img
    for img_path in sorted(Path("static/img").glob("*.jpg")):
        print(f"Extracting features from {img_path}")
        # Extract feature vector
        feature = fe.extract(img=Image.open(img_path))
        # Save feature vector
        feature_path = Path("static/feature") / (img_path.stem + ".npy")
        np.save(feature_path, feature)