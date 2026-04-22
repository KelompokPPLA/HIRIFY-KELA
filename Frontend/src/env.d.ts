declare interface ImportMetaEnv {
  readonly VITE_SUPABASE_URL: string;
  readonly VITE_SUPABASE_PUBLISHABLE_KEY: string;
  // add other VITE_ vars here as needed
}

declare interface ImportMeta {
  readonly env: ImportMetaEnv;
}
