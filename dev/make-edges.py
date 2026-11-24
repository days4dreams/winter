"""
Makes the torn-paper edge shapes in images/edges/ (run: python3 dev/make-edges.py).

Each is a 1200px-wide strip that tiles side by side. The ragged line is a
random walk with small jitter, so it reads as torn paper rather than a saw
blade. The "seed" numbers pick one particular tear; change them for another.
Also prints the outline for the torn photo cards, used in css/style.css.
"""
import random, pathlib

OUT = pathlib.Path(__file__).resolve().parent.parent / 'images' / 'edges'

def ragged_line(seed, w, step, amp):
    r = random.Random(seed); x = 0; y = (amp[0] + amp[1]) / 2; pts = []
    while x < w:
        y = min(amp[1], max(amp[0], y + r.uniform(-3.5, 3.5)))
        nick = r.uniform(3, 7) if r.random() < .06 else 0   # an occasional deeper nick
        pts.append((x, y + r.uniform(-1.2, 1.2) + nick)); x += r.uniform(*step)
    pts[0] = (0, (amp[0] + amp[1]) / 2)
    pts.append((w, pts[0][1]))  # same height at both ends, so the strip tiles
    return pts

def strip(name, seed, step, amp, inverse=False, offset=0, w=1200, h=28):
    """Filled below the line (an edge), or above it when inverse (paper over a photo)."""
    line = ' '.join('L%.1f %.1f' % (x, y + offset) for x, y in ragged_line(seed, w, step, amp))
    h += offset
    d = f'M0 0 {line} L{w} 0 Z' if inverse else f'M0 {h} {line} L{w} {h} Z'
    (OUT / name).write_text(f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w} {h}" preserveAspectRatio="none"><path d="{d}"/></svg>\n')

def card_outline(seed, n=46, depth=1.4):
    r = random.Random(seed); pts = []
    for i in range(n): pts.append((i / n * 100, r.uniform(0, depth)))
    for i in range(n): pts.append((100 - r.uniform(0, depth * .7), i / n * 100))
    for i in range(n): pts.append((100 - i / n * 100, 100 - r.uniform(0, depth)))
    for i in range(n): pts.append((r.uniform(0, depth * .7), 100 - i / n * 100))
    return 'polygon(' + ', '.join('%.2f%% %.2f%%' % p for p in pts) + ')'

OUT.mkdir(parents=True, exist_ok=True)
strip('torn-edge.svg', 3, (2, 6), (6, 20))                              # the band's own colour
strip('torn-paper.svg', 11, (2, 5), (3, 17))                            # the pale paper behind it
strip('torn-edge-over-photo.svg', 3, (2, 6), (6, 20), inverse=True, offset=6)
print(card_outline(7))
