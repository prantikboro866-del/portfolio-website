import os
from PIL import Image, ImageFilter, ImageDraw
import time

frame_dir = 'frame'

def process_image(img_path):
    img = Image.open(img_path).convert('RGB')
    width, height = img.size
    
    cx, cy = width // 2, height // 2
    box_size = 300
    
    box = (cx - box_size//2, cy - box_size//2, cx + box_size//2, cy + box_size//2)
    
    # Extract the region
    region = img.crop(box)
    
    # Apply a heavy blur to smooth out the watermark
    blurred_region = region.filter(ImageFilter.GaussianBlur(radius=40))
    
    # Create a radial gradient mask to blend the blurred region seamlessly
    mask = Image.new('L', (box_size, box_size), 0)
    draw = ImageDraw.Draw(mask)
    
    # Draw concentric circles to create a soft feather effect
    # The center will be fully opaque (255), edges transparent (0)
    center = box_size // 2
    for r in range(box_size // 2, 0, -1):
        alpha = int(255 * (1 - (r / (box_size // 2))**2)) # Quadratic falloff
        draw.ellipse((center - r, center - r, center + r, center + r), fill=alpha)
    
    # Paste using the mask
    img.paste(blurred_region, box, mask)
    
    img.save(img_path)

if __name__ == '__main__':
    start_time = time.time()
    count = 0
    for filename in sorted(os.listdir(frame_dir)):
        if filename.endswith('.png'):
            filepath = os.path.join(frame_dir, filename)
            try:
                process_image(filepath)
                count += 1
            except Exception as e:
                print(f"Error processing {filename}: {e}")
    print(f"Processed {count} images in {time.time() - start_time:.2f} seconds.")
