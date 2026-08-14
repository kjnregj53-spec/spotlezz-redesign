/**
 * Minimale statische server voor lokaal controleren.
 * Bootst het gedrag van Vercel na: cleanUrls, trailingSlash en de redirects
 * uit vercel.json, zodat de routing lokaal hetzelfde werkt als op de preview.
 *
 *   node build/serve.mjs [poort]
 */

import { createServer } from 'node:http';
import { readFile, stat } from 'node:fs/promises';
import { existsSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..', 'spotlezz.vercel.app');
const PORT = Number(process.argv[2]) || 4321;

const vercel = JSON.parse(
  await readFile(path.join(ROOT, 'vercel.json'), 'utf8').catch(() => '{"redirects":[]}')
);

const TYPES = {
  '.html': 'text/html; charset=utf-8',
  '.css': 'text/css; charset=utf-8',
  '.js': 'text/javascript; charset=utf-8',
  '.json': 'application/json; charset=utf-8',
  '.xml': 'application/xml; charset=utf-8',
  '.txt': 'text/plain; charset=utf-8',
  '.svg': 'image/svg+xml',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.png': 'image/png',
  '.webp': 'image/webp',
  '.ico': 'image/x-icon',
};

function matchRedirect(pathname) {
  for (const r of vercel.redirects || []) {
    const src = r.source.replace(/\/:path\*$/, '');
    if (pathname === src || pathname === src + '/' || pathname.startsWith(src + '/')) {
      return r.destination.endsWith('/') ? r.destination : r.destination + '/';
    }
  }
  return null;
}

createServer(async (req, res) => {
  let pathname = decodeURIComponent(new URL(req.url, 'http://x').pathname);

  const redirect = matchRedirect(pathname);
  if (redirect && redirect !== pathname) {
    res.writeHead(308, { Location: redirect });
    return res.end();
  }

  // cleanUrls: /pad.html -> /pad/
  if (pathname.endsWith('/index.html')) {
    res.writeHead(308, { Location: pathname.replace(/index\.html$/, '') });
    return res.end();
  }

  let file = path.join(ROOT, pathname);
  try {
    const s = await stat(file).catch(() => null);
    if (s && s.isDirectory()) file = path.join(file, 'index.html');
    else if (!s && existsSync(file + '/index.html')) file = file + '/index.html';
    else if (!s && existsSync(file + '.html')) file = file + '.html';

    if (!existsSync(file)) {
      res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
      return res.end('<h1>404</h1><p>Niet gevonden: ' + pathname + '</p>');
    }

    const body = await readFile(file);
    res.writeHead(200, { 'Content-Type': TYPES[path.extname(file)] || 'application/octet-stream' });
    res.end(body);
  } catch (e) {
    res.writeHead(500, { 'Content-Type': 'text/plain' });
    res.end('500 ' + e.message);
  }
}).listen(PORT, () => {
  console.log(`Spotlezz preview draait op http://localhost:${PORT}/`);
});
