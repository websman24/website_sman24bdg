import { describe, it, expect, beforeEach } from 'vitest';
import { fireEvent } from '@testing-library/dom';

describe('Frontend Component & DOM Mock Tests', () => {
  beforeEach(() => {
    document.body.innerHTML = `
      <div id="app" class="p-4">
        <h1 id="school-title">SMA Negeri 24 Bandung</h1>
        <button id="toggle-btn" class="btn">Buka Menu</button>
        <div id="mobile-menu" class="hidden">
          <a href="/profil">Profil Sekolah</a>
          <a href="/berita">Berita Utama</a>
        </div>
      </div>
    `;
  });

  it('renders school title correctly in DOM environment', () => {
    const title = document.getElementById('school-title');
    expect(title).not.toBeNull();
    expect(title?.textContent).toBe('SMA Negeri 24 Bandung');
  });

  it('handles menu toggle button click events accurately', async () => {
    const button = document.getElementById('toggle-btn');
    const menu = document.getElementById('mobile-menu');

    expect(menu?.classList.contains('hidden')).toBe(true);

    button?.addEventListener('click', () => {
      menu?.classList.toggle('hidden');
    });

    if (button) {
      await fireEvent.click(button);
    }

    expect(menu?.classList.contains('hidden')).toBe(false);
  });
});
